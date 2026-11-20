<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Template;
use App\Models\Package;
use App\Models\User;
use App\Models\Invitation;
use App\Models\InvitationEvent;
use App\Models\InvitationContent;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Show the 3-step checkout wizard
     */
    public function checkout(Request $request)
    {
        $templates = Template::where('is_active', true)->with('category')->get();
        
        $selectedTemplateSlug = $request->query('template', 'elegance-wedding');
        $selectedTemplate = Template::where('slug', $selectedTemplateSlug)->first() ?? $templates->first();

        $packageSlug = $request->query('package', 'premium');
        $selectedPackage = Package::where('slug', $packageSlug)->first() ?? Package::where('slug', 'premium')->first();

        return view('order.checkout', compact('templates', 'selectedTemplate', 'selectedPackage'));
    }

    /**
     * Store order data (Step 2 -> Step 3)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_id' => 'required|exists:templates,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_email' => 'required|email|max:255',
            'event_title' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'groom_name' => 'nullable|string|max:255',
            'bride_name' => 'nullable|string|max:255',
            'event_location' => 'nullable|string|max:255',
        ]);

        $template = Template::findOrFail($validated['template_id']);
        $package = Package::where('slug', 'premium')->first() ?? Package::first();

        // 1. Find or create user
        $user = User::firstOrCreate(
            ['email' => $validated['customer_email']],
            [
                'name' => $validated['customer_name'],
                'phone' => $validated['customer_phone'],
                'password' => Hash::make(Str::random(12)),
                'status' => 'active',
            ]
        );
        $user->roles()->syncWithoutDetaching([3]);

        // 2. Generate unique order code e.g. INV-2024121
        $orderCode = 'INV-' . date('Y') . strtoupper(Str::random(4));
        $price = $template->effective_price;

        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => $orderCode,
            'total_amount' => $price,
            'discount_amount' => 0,
            'final_amount' => $price,
            'status' => 'pending',
            'notes' => 'Pesanan ' . $template->name . ' oleh ' . $validated['customer_name'],
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'item_type' => 'template',
            'item_id' => $template->id,
            'name' => 'Template ' . $template->name,
            'quantity' => 1,
            'price' => $price,
        ]);

        // 3. Create Draft / Pending Invitation
        $invitationSlug = Str::slug($validated['customer_name'] . '-' . Str::random(5));
        if (!empty($validated['groom_name']) && !empty($validated['bride_name'])) {
            $invitationSlug = Str::slug($validated['groom_name'] . '-' . $validated['bride_name'] . '-' . Str::random(4));
        }

        $invitation = Invitation::create([
            'user_id' => $user->id,
            'template_id' => $template->id,
            'package_id' => $package ? $package->id : null,
            'order_id' => $order->id,
            'slug' => $invitationSlug,
            'title' => $validated['event_title'] ?? ('Undangan ' . $template->name . ' - ' . $validated['customer_name']),
            'status' => 'pending',
            'starts_at' => $validated['event_date'] ? Carbon::parse($validated['event_date']) : Carbon::now()->addDays(30),
        ]);

        // Create initial events & content
        InvitationEvent::create([
            'invitation_id' => $invitation->id,
            'event_name' => 'Akad / Acara Utama',
            'event_date' => $validated['event_date'] ?? date('Y-m-d', strtotime('+30 days')),
            'event_time' => '09:00:00',
            'location' => $validated['event_location'] ?? 'Jakarta',
            'description' => 'Momen sakral penuh berkah.',
        ]);

        InvitationContent::create([
            'invitation_id' => $invitation->id,
            'key' => 'groom_name',
            'value' => $validated['groom_name'] ?? $validated['customer_name'],
        ]);

        InvitationContent::create([
            'invitation_id' => $invitation->id,
            'key' => 'bride_name',
            'value' => $validated['bride_name'] ?? 'Pasangan',
        ]);

        return redirect()->route('order.payment', ['order_code' => $order->order_code]);
    }

    /**
     * Show Payment Step (Step 3)
     */
    public function payment($order_code)
    {
        $order = Order::where('order_code', $order_code)->with('user', 'items', 'invitation')->firstOrFail();
        $storeSettings = StoreSetting::all()->pluck('value', 'key');

        return view('order.payment', compact('order', 'storeSettings'));
    }

    /**
     * Process / Confirm Payment
     */
    public function confirmPayment(Request $request, $order_code)
    {
        $order = Order::where('order_code', $order_code)->with('user', 'items', 'invitation')->firstOrFail();
        
        $paymentMethod = $request->input('payment_method', 'qris');
        
        $order->update([
            'status' => 'paid',
            'payment_method' => $paymentMethod,
        ]);

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'midtrans_transaction_id' => strtoupper($paymentMethod) . '-' . $order->order_code,
                'method' => $paymentMethod,
                'status' => 'paid',
                'amount' => $order->final_amount,
                'paid_at' => now(),
                'raw_response' => json_encode(['provider' => $paymentMethod, 'status' => 'settlement']),
            ]
        );

        if ($order->invitation) {
            $order->invitation->update([
                'status' => 'published',
                'published_at' => now(),
            ]);
        }

        return redirect()->route('order.success', ['order_code' => $order->order_code]);
    }

    /**
     * Show Success Screen & WhatsApp message mockup (Step 4)
     */
    public function success($order_code)
    {
        $order = Order::where('order_code', $order_code)->with('user', 'items', 'payment', 'invitation.template')->firstOrFail();
        $storeSettings = StoreSetting::all()->pluck('value', 'key');
        
        $invitationUrl = $order->invitation 
            ? url('/invitation/' . $order->invitation->slug)
            : url('/');

        $templateName = $order->items->first() ? $order->items->first()->name : 'Elegance Wedding';
        $templateName = str_replace('Template ', '', $templateName);

        // Build WhatsApp message text matching the mockup in Image 2
        $customerName = $order->user ? $order->user->name : 'Pelanggan';
        $whatsappText = "Halo Kak {$customerName},\n"
            . "Terima kasih telah memesan di DETROIT!\n\n"
            . "Berikut detail pesanan Anda:\n"
            . "📦 Template: {$templateName}\n"
            . "💰 Total: Rp " . number_format($order->final_amount, 0, ',', '.') . "\n"
            . "💳 Metode: " . strtoupper($order->payment_method ?? 'QRIS') . "\n\n"
            . "🔗 Link Undangan Anda:\n"
            . "{$invitationUrl}\n\n"
            . "Terima kasih telah mempercayakan momen spesial Anda kepada kami. ❤️";

        $phone = $order->user ? preg_replace('/[^0-9]/', '', $order->user->phone) : '6281234567890';
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        $whatsappUrl = "https://api.whatsapp.com/send?phone={$phone}&text=" . urlencode($whatsappText);

        return view('order.success', compact('order', 'storeSettings', 'invitationUrl', 'templateName', 'whatsappText', 'whatsappUrl', 'phone'));
    }
}
