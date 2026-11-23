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

    public function getPreviewThemeAttribute(): array
    {
        return match ($this->slug) {
            'elegance-wedding' => [
                'style' => 'wedding-arch',
                'bg' => '#072017',
                'primary' => '#D4AF37',
                'text' => '#F8F5EE',
                'eyebrow' => 'The Wedding Of',
                'names' => 'Aulia & Rama',
                'date' => 'SABTU, 24 JANUARI 2026',
            ],
            'wedding-rizky-dinda' => [
                'style' => 'wedding-gate',
                'bg' => '#FAF5EE',
                'primary' => '#D4AF37',
                'text' => '#2C241E',
                'eyebrow' => 'The Wedding Of',
                'names' => 'Rizky & Dinda',
                'date' => 'MINGGU, 22 DESEMBER 2026',
            ],
            'khitan-ahmad-fathan' => [
                'style' => 'islamic-night',
                'bg' => '#142B47',
                'primary' => '#E8C36A',
                'text' => '#FFFFFF',
                'eyebrow' => 'Tasyakuran',
                'names' => 'Khitan Ahmad Fathan',
                'date' => 'MARET 2026',
            ],
            'birthday-nayla-8' => [
                'style' => 'birthday-fun',
                'bg' => '#FFE8EC',
                'primary' => '#D85A7F',
                'text' => '#2E282A',
                'eyebrow' => 'Happy Birthday',
                'names' => 'Nayla Turning 8',
                'date' => 'JANUARI 2026',
            ],
            'aqiqah-baby-arka' => [
                'style' => 'nature-soft',
                'bg' => '#F2F7F2',
                'primary' => '#7A9A7B',
                'text' => '#4B634C',
                'eyebrow' => 'Aqiqah',
                'names' => 'Baby Arka',
                'date' => 'FEBRUARI 2026',
            ],
            'engagement-rara-fajar' => [
                'style' => 'floral-pink',
                'bg' => '#FFF0F3',
                'primary' => '#E07A5F',
                'text' => '#4A1E2B',
                'eyebrow' => 'The Engagement',
                'names' => 'Rara & Fajar',
                'date' => 'AGUSTUS 2026',
            ],
            'undangan-pengajian' => [
                'style' => 'islamic-dark',
                'bg' => '#1B1713',
                'primary' => '#D4AF37',
                'text' => '#F4E0A5',
                'eyebrow' => 'Undangan',
                'names' => 'Pengajian Bersama',
                'date' => 'SETIAP JUMAT',
            ],
            'royal-classic-gold' => [
                'style' => 'royal-gold',
                'bg' => '#FFFFFF',
                'primary' => '#B8860B',
                'text' => '#2C241E',
                'eyebrow' => 'The Wedding Of',
                'names' => 'Royal Classic Gold Wedding',
                'date' => 'SABTU, 14 JUN 2026',
            ],
            'sweet-seventeen-glam' => [
                'style' => 'glam-party',
                'bg' => '#111111',
                'primary' => '#FFD700',
                'text' => '#FFFFFF',
                'eyebrow' => 'Sweet',
                'names' => 'Seventeen Glam',
                'date' => 'JULI 2026',
            ],
            'walimatussafar-haji-umroh' => [
                'style' => 'islamic-peace',
                'bg' => '#10281E',
                'primary' => '#C5A059',
                'text' => '#F4E0A5',
                'eyebrow' => 'Walimatussafar',
                'names' => 'Haji & Umroh',
                'date' => '2026',
            ],
            default => [
                'style' => 'wedding-arch',
                'bg' => '#FCF9F5',
                'primary' => '#B8860B',
                'text' => '#2C241E',
                'eyebrow' => 'The Wedding Of',
                'names' => 'Elegance Wedding',
                'date' => 'SABTU, 14 DESEMBER 2026',
            ],
        };
    }
}
