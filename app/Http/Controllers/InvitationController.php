<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationRsvp;
use App\Models\InvitationMessage;
use App\Models\Template;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /**
     * Show live digital invitation
     */
    public function show($slug, Request $request)
    {
        $invitation = Invitation::where('slug', $slug)
            ->orWhere('slug', 'like', $slug . '%')
            ->with(['template', 'events', 'contents', 'messages' => function ($q) {
                $q->where('is_approved', true)->latest();
            }, 'rsvps'])
            ->first();

        if (!$invitation) {
            // Check if slug matches a template slug
            $tpl = Template::where('slug', $slug)->first();
            if ($tpl) {
                return $this->demo($slug, $request);
            }

            // Fallback to first invitation if mockup dummy slug e.g. abc123 or andika-salsabila
            $invitation = Invitation::with(['template', 'events', 'contents', 'messages' => function ($q) {
                $q->where('is_approved', true)->latest();
            }, 'rsvps'])->firstOrFail();
        }

        $guestName = $request->query('to', 'Tamu Undangan');
        
        // Map content keys to easily accessible array
        $content = [];
        foreach ($invitation->contents as $item) {
            $content[$item->key] = $item->value;
        }

        // Get main event
        $primaryEvent = $invitation->events->first();
        $secondaryEvent = $invitation->events->skip(1)->first();
        $eventDateLabel = $primaryEvent?->event_date ? $primaryEvent->event_date->locale('id')->isoFormat('dddd, D MMMM YYYY') : 'Sabtu, 14 Desember 2024';

        // Tentukan view berdasarkan slug template
        $viewPath = 'invitation.templates.' . ($invitation->template->slug ?? 'default');
        if (!view()->exists($viewPath)) {
            $viewPath = 'invitation.show';
        }

        return view($viewPath, compact('invitation', 'guestName', 'content', 'primaryEvent', 'secondaryEvent', 'eventDateLabel'));
    }

    /**
     * Show template demo with real invitation design (in-memory sample data)
     */
    public function demo($slug, Request $request)
    {
        $template = Template::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $theme = $template->preview_theme;

        $nameParts = array_values(array_filter(array_map('trim', explode('&', (string) $theme['names']))));
        $groomName = $nameParts[0] ?? 'Calon Pengantin';
        $brideName = $nameParts[1] ?? $groomName;

        $invitation = new Invitation();
        $invitation->slug = 'demo-' . $template->slug;
        $invitation->title = $template->name;
        $invitation->status = 'published';
        $invitation->setRelation('template', $template);
        $invitation->setRelation('events', new Collection([
            new \App\Models\InvitationEvent([
                'invitation_id' => null,
                'event_name' => 'Rangkaian Acara Utama',
                'event_date' => \Carbon\Carbon::now()->addDays(45),
                'event_time' => '09:00 WIB',
                'location' => 'Jakarta',
                'description' => 'Rangkaian acara utama undangan.',
            ]),
        ]));
        $invitation->setRelation('contents', new Collection());
        $invitation->setRelation('messages', new Collection());
        $invitation->setRelation('rsvps', new Collection());

        $content = [
            'groom_name' => $groomName,
            'bride_name' => $brideName,
            'groom_parents' => 'Bapak/Ibu dari ' . $groomName,
            'bride_parents' => 'Bapak/Ibu dari ' . $brideName,
            'groom_instagram' => strtolower(str_replace(' ', '', $groomName)),
            'bride_instagram' => strtolower(str_replace(' ', '', $brideName)),
            'quote' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
            'quote_source' => 'QS. Ar-Rum: 21',
            'bank_1_name' => 'Bank BCA',
            'bank_1_number' => '5420918273',
            'bank_1_holder' => 'a.n ' . $groomName,
            'bank_2_name' => 'Bank Mandiri',
            'bank_2_number' => '1270009827162',
            'bank_2_holder' => 'a.n ' . $brideName,
        ];

        $primaryEvent = $invitation->events->first();
        $secondaryEvent = $invitation->events->skip(1)->first();
        $eventDateLabel = $primaryEvent?->event_date ? $primaryEvent->event_date->locale('id')->isoFormat('dddd, D MMMM YYYY') : 'Sabtu, 14 Desember 2024';

        $guestName = $request->query('to', 'Tamu Undangan');

        // Tentukan view berdasarkan slug template
        $viewPath = 'invitation.templates.' . ($template->slug);
        if (!view()->exists($viewPath)) {
            $viewPath = 'invitation.show';
        }

        return view($viewPath, compact('invitation', 'guestName', 'content', 'primaryEvent', 'secondaryEvent', 'eventDateLabel'));
    }

    /**
     * Store RSVP response
     */
    public function rsvp(Request $request, $slug)
    {
        if (str_starts_with($slug, 'demo-')) {
            return response()->json([
                'success' => true,
                'message' => 'Demo: Konfirmasi kehadiran Anda berhasil dikirim! (Data tidak disimpan)',
            ]);
        }

        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'attendance' => 'required|in:yes,no,maybe',
            'total_guests' => 'required|integer|min:1|max:10',
            'message' => 'nullable|string|max:1000',
        ]);

        $rsvp = InvitationRsvp::create([
            'invitation_id' => $invitation->id,
            'name' => $validated['name'],
            'attendance' => $validated['attendance'],
            'total_guests' => $validated['total_guests'],
            'message' => $validated['message'] ?? null,
        ]);

        if (!empty($validated['message'])) {
            InvitationMessage::create([
                'invitation_id' => $invitation->id,
                'name' => $validated['name'],
                'message' => $validated['message'],
                'is_approved' => true,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih, konfirmasi kehadiran Anda berhasil dikirim!',
                'data' => $rsvp,
            ]);
        }

        return redirect()->back()->with('success_rsvp', 'Terima kasih, konfirmasi kehadiran Anda berhasil dikirim!');
    }

    /**
     * Store guestbook message / ucapan
     */
    public function message(Request $request, $slug)
    {
        if (str_starts_with($slug, 'demo-')) {
            return response()->json([
                'success' => true,
                'message' => 'Demo: Ucapan & doa Anda berhasil dikirim! (Data tidak disimpan)',
                'data' => [
                    'name' => $request->name ?? 'Tamu',
                    'message' => $request->message ?? '',
                    'created_at' => 'Baru saja',
                ],
            ]);
        }

        $invitation = Invitation::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $msg = InvitationMessage::create([
            'invitation_id' => $invitation->id,
            'name' => $validated['name'],
            'message' => $validated['message'],
            'is_approved' => true,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ucapan & doa Anda berhasil dikirim!',
                'data' => [
                    'name' => $msg->name,
                    'message' => $msg->message,
                    'created_at' => $msg->created_at->diffForHumans(),
                ],
            ]);
        }

        return redirect()->back()->with('success_msg', 'Ucapan & doa Anda berhasil dikirim!');
    }
}
