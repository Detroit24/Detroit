<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('q');

        $query = Order::with('user', 'items', 'payment', 'invitation')->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders', 'status', 'search'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'items', 'payment', 'invitation.template', 'invitation.events')->findOrFail($id);

        $invitationUrl = $order->invitation ? url('/invitation/' . $order->invitation->slug) : url('/');
        $templateName = $order->items->first() ? str_replace('Template ', '', $order->items->first()->name) : 'Elegance Wedding';
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

        return view('admin.orders.show', compact('order', 'whatsappUrl', 'invitationUrl', 'whatsappText'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $status = $request->validate([
            'status' => 'required|in:pending,paid,failed,cancelled,expired',
        ])['status'];

        $order->update(['status' => $status]);

        if ($status === 'paid') {
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'midtrans_transaction_id' => 'ADMIN-VERIFY-' . $order->order_code,
                    'method' => $order->payment_method ?? 'transfer',
                    'status' => 'paid',
                    'amount' => $order->final_amount,
                    'paid_at' => now(),
                ]
            );

            if ($order->invitation) {
                $order->invitation->update([
                    'status' => 'published',
                    'published_at' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . strtoupper($status));
    }
}
