<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationRsvp;
use App\Models\InvitationMessage;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /**
     * Show live digital invitation
     */
    public function show($slug, Request $request)
    {
        $invitation = Invitation::where('slug', $slug)
            ->with(['template', 'events', 'contents', 'messages' => function ($q) {
                $q->where('is_approved', true)->latest();
            }, 'rsvps'])
            ->firstOrFail();

        $guestName = $request->query('to', 'Tamu Undangan');
        
        // Map content keys to easily accessible array
        $content = [];
        foreach ($invitation->contents as $item) {
            $content[$item->key] = $item->value;
        }

        // Get main event
        $primaryEvent = $invitation->events->first();
        $secondaryEvent = $invitation->events->skip(1)->first();

        return view('invitation.show', compact('invitation', 'guestName', 'content', 'primaryEvent', 'secondaryEvent'));
    }

    /**
     * Store RSVP response
     */
    public function rsvp(Request $request, $slug)
    {
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
