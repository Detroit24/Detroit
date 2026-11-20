<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'package_id',
        'order_id',
        'slug',
        'title',
        'status',
        'starts_at',
        'expires_at',
        'published_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function events()
    {
        return $this->hasMany(InvitationEvent::class);
    }

    public function contents()
    {
        return $this->hasMany(InvitationContent::class);
    }

    public function messages()
    {
        return $this->hasMany(InvitationMessage::class);
    }

    public function rsvps()
    {
        return $this->hasMany(InvitationRsvp::class);
    }

    public function getContent(string $key, $default = null)
    {
        $item = $this->contents->firstWhere('key', $key);
        return $item ? $item->value : $default;
    }
}
