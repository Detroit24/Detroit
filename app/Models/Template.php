<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'preview_image',
        'description',
        'is_active',
        'price_override',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_override' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(TemplateCategory::class, 'category_id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'template_package');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function getEffectivePriceAttribute()
    {
        if ($this->price_override !== null && $this->price_override > 0) {
            return $this->price_override;
        }
        return 149000;
    }
}
