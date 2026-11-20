<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'event_name',
        'event_date',
        'event_time',
        'location',
        'maps_url',
        'description',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
