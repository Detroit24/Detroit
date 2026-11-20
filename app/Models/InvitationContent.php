<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationContent extends Model
{
    use HasFactory;

    protected $table = 'invitation_content';

    protected $fillable = [
        'invitation_id',
        'key',
        'value',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
