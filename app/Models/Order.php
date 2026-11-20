<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'total_amount',
        'discount_amount',
        'final_amount',
        'status',
        'payment_method',
        'coupon_id',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function invitation()
    {
        return $this->hasOne(Invitation::class);
    }

    public function getFormattedFinalAmountAttribute()
    {
        return 'Rp ' . number_format($this->final_amount, 0, ',', '.');
    }
}
