<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationRsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'guest_id',
        'name',
        'attendance',
        'total_guests',
        'message',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
