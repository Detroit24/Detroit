<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'message',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
