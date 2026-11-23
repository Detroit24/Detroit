<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\TemplateCategory;
use App\Models\Template;
use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $roles = [
            ['id' => 1, 'name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Akses penuh sistem'],
            ['id' => 2, 'name' => 'Admin', 'slug' => 'admin', 'description' => 'Admin operasional'],
            ['id' => 3, 'name' => 'Customer', 'slug' => 'customer', 'description' => 'Pelanggan Detroit'],
        ];
        foreach ($roles as $r) {
            Role::updateOrCreate(['id' => $r['id']], $r);
        }

        // 2. Staff accounts (akses panel admin).
        //    Password diambil dari env SUPER_ADMIN_PASSWORD / ADMIN_PASSWORD (default: "password").
        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@detroit.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make(env('SUPER_ADMIN_PASSWORD', 'password')),
                'phone' => '081234567899',
                'status' => 'active',
            ]
        );
        $superadmin->roles()->syncWithoutDetaching([1]);

        $admin = User::updateOrCreate(
            ['email' => 'admin@detroit.id'],
            [
                'name' => 'Admin Detroit',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'phone' => '081234567890',
                'status' => 'active',
            ]
        );
        $admin->roles()->syncWithoutDetaching([2]);

        // 3. Template Categories (katalog template usaha)
        $categories = [
            [
                'id' => 1,
                'name' => 'Pernikahan & Lamaran',
                'slug' => 'pernikahan-lamaran',
                'description' => 'Undangan digital momen sakral pernikahan dan tunangan yang elegan & berkesan.',
                'icon' => 'bi-heart',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Khitanan & Aqiqah',
                'slug' => 'khitanan-aqiqah',
                'description' => 'Undangan syukuran khitanan putra tercinta dan aqiqah buah hati dengan doa penuh berkah.',
                'icon' => 'bi-moon-stars',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Ulang Tahun & Anniversary',
                'slug' => 'ulang-tahun-anniversary',
                'description' => 'Rayakan pertambahan usia, sweet sixteen, hingga hari jadi spesial Anda.',
                'icon' => 'bi-cake2',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => 'Pengajian & Acara Islami',
                'slug' => 'pengajian-islami',
                'description' => 'Undangan pengajian akbar, walimatussafar haji/umroh, tasyakuran rumah baru, dan majelis ta\'lim.',
                'icon' => 'bi-book',
                'is_active' => true,
            ],
            [
                'id' => 5,
                'name' => 'Acara Lainnya',
                'slug' => 'acara-lainnya',
                'description' => 'Undangan wisuda, reuni, gathering komunitas, peluncuran bisnis, dan perayaan lainnya.',
                'icon' => 'bi-star',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            TemplateCategory::updateOrCreate(['slug' => $cat['slug']], [
                'name' => $cat['name'],
                'description' => $cat['description'],
                'icon' => $cat['icon'],
                'is_active' => $cat['is_active'],
            ]);
        }

        // 4. Packages (katalog paket usaha)
        $packages = [
            [
                'id' => 1,
                'name' => 'Basic',
                'slug' => 'basic',
                'price' => 99000,
                'duration_days' => 365,
                'features' => ['1 Template Premium', 'Akses Selamanya', 'Support via WhatsApp'],
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Premium',
                'slug' => 'premium',
                'price' => 149000,
                'duration_days' => 365,
                'features' => ['10+ Template Premium', 'Custom Nama & Tanggal', 'Support Prioritas', 'Galeri Foto & Musik BGM', 'Amplop Digital / Bank Gift', 'RSVP & Buku Tamu Live'],
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'price' => 299000,
                'duration_days' => 365,
                'features' => ['Semua Template Premium', 'Fitur Custom Desain', 'Prioritas Support', 'Domain Sendiri / Custom Domain', 'Unlimited Tamu Undangan', 'Export Data RSVP Excel'],
                'is_active' => true,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(['slug' => $pkg['slug']], [
                'name' => $pkg['name'],
                'price' => $pkg['price'],
                'duration_days' => $pkg['duration_days'],
                'features' => $pkg['features'],
                'is_active' => $pkg['is_active'],
            ]);
        }

        // 5. Templates (katalog template usaha)
        $templates = [
            [
                'id' => 1,
                'category_id' => 1,
                'name' => 'Elegance Wedding',
                'slug' => 'elegance-wedding',
                'preview_image' => 'templates/wedding-andika.jpg',
                'description' => 'Desain mawar putih champagne dengan sentuhan tipografi elegan, cocok untuk pernikahan sakral & modern.',
                'is_active' => true,
                'price_override' => 149000,
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'name' => 'The Wedding Of Rizky & Dinda',
                'slug' => 'wedding-rizky-dinda',
                'preview_image' => 'templates/wedding-rizky.jpg',
                'description' => 'Perpaduan gerbang bunga klasik dan floral ivory lembut yang memancarkan kehangatan cinta sejati.',
                'is_active' => true,
                'price_override' => 149000,
            ],
            [
                'id' => 3,
                'category_id' => 2,
                'name' => 'Tasyakuran Khitan Ahmad Fathan',
                'slug' => 'khitan-ahmad-fathan',
                'preview_image' => 'templates/khitan-ahmad.jpg',
                'description' => 'Nuansa biru megah bermotif kubah istana dan bintang emas, menghadirkan nuansa tasyakuran penuh doa.',
                'is_active' => true,
                'price_override' => 149000,
            ],
            [
                'id' => 4,
                'category_id' => 3,
                'name' => 'Happy Birthday Nayla Turning 8',
                'slug' => 'birthday-nayla-8',
                'preview_image' => 'templates/birthday-nayla.jpg',
                'description' => 'Balon pastel ceria dengan hiasan pita manis, pilihan terfavorit untuk pesta ulang tahun anak dan remaja.',
                'is_active' => true,
                'price_override' => 149000,
            ],
            [
                'id' => 5,
                'category_id' => 2,
                'name' => 'Aqiqah Baby Arka',
                'slug' => 'aqiqah-baby-arka',
                'preview_image' => 'templates/aqiqah-baby.jpg',
                'description' => 'Kelembutan sentuhan dedaunan sage green dan frame foto bayi suci untuk tasyakuran aqiqah ananda tercinta.',
                'is_active' => true,
                'price_override' => 149000,
            ],
            [
                'id' => 6,
                'category_id' => 1,
                'name' => 'The Engagement Rara & Fajar',
                'slug' => 'engagement-rara-fajar',
                'preview_image' => 'templates/engagement-rara.jpg',
                'description' => 'Bunga blush pink bermekaran mengiringi janji suci pertunangan dan lamaran yang manis & romantis.',
                'is_active' => true,
                'price_override' => 149000,
            ],
            [
                'id' => 7,
                'category_id' => 4,
                'name' => 'Undangan Pengajian & Doa Bersama',
                'slug' => 'undangan-pengajian',
                'preview_image' => 'templates/pengajian.jpg',
                'description' => 'Latar hitam elegan dengan hiasan ornamen arabesque emas berkilau untuk acara syukuran dan majelis dzikir.',
                'is_active' => true,
                'price_override' => 149000,
            ],
            [
                'id' => 8,
                'category_id' => 1,
                'name' => 'Royal Classic Gold Wedding',
                'slug' => 'royal-classic-gold',
                'preview_image' => 'templates/royal-wedding.jpg',
                'description' => 'Kemewahan nuansa kerajaan dengan bingkai emas mewah dan ornamen klasik yang tak lekang oleh waktu.',
                'is_active' => true,
                'price_override' => 149000,
            ],
            [
                'id' => 9,
                'category_id' => 3,
                'name' => 'Sweet Seventeen Glam',
                'slug' => 'sweet-seventeen-glam',
                'preview_image' => 'templates/sweet-seventeen.jpg',
                'description' => 'Perayaan ulang tahun ke-17 bertema glitter champagne & rose gold yang mempesona para tamu.',
                'is_active' => true,
                'price_override' => 149000,
            ],
            [
                'id' => 10,
                'category_id' => 4,
                'name' => 'Walimatussafar Haji & Umroh',
                'slug' => 'walimatussafar-haji-umroh',
                'preview_image' => 'templates/walimatussafar.jpg',
                'description' => 'Undangan doa restu keberangkatan ibadah ke baitullah dengan kaligrafi dan ornamen Nabawi.',
                'is_active' => true,
                'price_override' => 149000,
            ],
        ];

        foreach ($templates as $tmpl) {
            $cat = TemplateCategory::find($tmpl['category_id']) ?? TemplateCategory::first();
            $created = Template::updateOrCreate(['slug' => $tmpl['slug']], [
                'category_id' => $cat->id,
                'name' => $tmpl['name'],
                'preview_image' => $tmpl['preview_image'],
                'description' => $tmpl['description'],
                'is_active' => $tmpl['is_active'],
                'price_override' => $tmpl['price_override'],
            ]);
            $created->packages()->syncWithoutDetaching(Package::pluck('id')->toArray());
        }
    }
}
