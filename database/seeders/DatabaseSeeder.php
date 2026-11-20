<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\TemplateCategory;
use App\Models\Template;
use App\Models\Package;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Invitation;
use App\Models\InvitationEvent;
use App\Models\InvitationContent;
use App\Models\InvitationMessage;
use App\Models\InvitationRsvp;
use App\Models\StoreSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // 2. Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@detroit.id'],
            [
                'name' => 'Admin Detroit',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'status' => 'active',
            ]
        );
        $admin->roles()->syncWithoutDetaching([2]);

        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@detroit.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'phone' => '081234567899',
                'status' => 'active',
            ]
        );
        $superadmin->roles()->syncWithoutDetaching([1]);

        $customer = User::updateOrCreate(
            ['email' => 'customer@detroit.id'],
            [
                'name' => 'Customer Demo',
                'password' => Hash::make('password'),
                'phone' => '081298765432',
                'status' => 'active',
            ]
        );
        $customer->roles()->syncWithoutDetaching([3]);

        $alfaro = User::updateOrCreate(
            ['email' => 'alfaro@email.com'],
            [
                'name' => 'Alfaro Fadhil',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'status' => 'active',
            ]
        );
        $alfaro->roles()->syncWithoutDetaching([3]);

        // 3. Template Categories (matching Image 1)
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
                'description' => 'Rayakan pertambahan usia, sweet seventeen, hingga hari jadi spesial Anda.',
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

        // 4. Packages (matching Image 1)
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

        // 5. Templates (matching Image 1 & 2)
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

        // 6. Store Settings
        $settings = [
            ['key' => 'store_name', 'value' => 'DETROIT Digital Invitation Studio', 'group' => 'general'],
            ['key' => 'store_tagline', 'value' => 'Buat undangan digital yang elegan, modern, dan berkesan dalam hitungan menit.', 'group' => 'general'],
            ['key' => 'whatsapp_number', 'value' => '6281234567890', 'group' => 'contact'],
            ['key' => 'store_email', 'value' => 'hello@detroit.id', 'group' => 'contact'],
            ['key' => 'store_address', 'value' => 'Jakarta, Indonesia', 'group' => 'contact'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/detroit.id', 'group' => 'social'],
            ['key' => 'tiktok_url', 'value' => 'https://tiktok.com/@detroit.id', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@detroit.id', 'group' => 'social'],
            ['key' => 'bank_bca_number', 'value' => '8271928371', 'group' => 'payment'],
            ['key' => 'bank_bca_holder', 'value' => 'DETROIT Studio', 'group' => 'payment'],
            ['key' => 'bank_mandiri_number', 'value' => '1370019283712', 'group' => 'payment'],
            ['key' => 'bank_mandiri_holder', 'value' => 'DETROIT Studio', 'group' => 'payment'],
            ['key' => 'qris_content', 'value' => '00020101021226670016ID.CO.DETROIT.QRIS5204581253033605802ID5914DETROIT STUDIO6007JAKARTA61051219062070703A016304E8A2', 'group' => 'payment'],
        ];

        foreach ($settings as $s) {
            StoreSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // 7. Seed Sample Invitation: Andika & Salsabila (abc123) matching Image 2!
        $invitation = Invitation::updateOrCreate(
            ['slug' => 'abc123'],
            [
                'user_id' => $alfaro->id,
                'template_id' => 1, // Elegance Wedding
                'package_id' => 2, // Premium
                'title' => 'The Wedding Of Andika & Salsabila',
                'status' => 'published',
                'starts_at' => Carbon::create(2024, 12, 14, 8, 0, 0),
                'published_at' => now(),
            ]
        );

        // Also seed slug 'andika-salsabila' as primary friendly url
        Invitation::updateOrCreate(
            ['slug' => 'andika-salsabila'],
            [
                'user_id' => $alfaro->id,
                'template_id' => 1,
                'package_id' => 2,
                'title' => 'The Wedding Of Andika & Salsabila',
                'status' => 'published',
                'starts_at' => Carbon::create(2024, 12, 14, 8, 0, 0),
                'published_at' => now(),
            ]
        );

        // Invitation Events
        InvitationEvent::updateOrCreate(
            ['invitation_id' => $invitation->id, 'event_name' => 'Akad Nikah'],
            [
                'event_date' => '2024-12-14',
                'event_time' => '08:00:00',
                'location' => 'Masjid Agung Sunda Kelapa, Menteng, Jakarta Pusat',
                'maps_url' => 'https://maps.google.com/?q=Masjid+Agung+Sunda+Kelapa',
                'description' => 'Momen sakral ijab kabul mengikat ikrar suci pernikahan.',
            ]
        );

        InvitationEvent::updateOrCreate(
            ['invitation_id' => $invitation->id, 'event_name' => 'Resepsi Pernikahan'],
            [
                'event_date' => '2024-12-14',
                'event_time' => '11:00:00',
                'location' => 'Grand Ballroom Hotel Indonesia Kempinski Jakarta',
                'maps_url' => 'https://maps.google.com/?q=Hotel+Indonesia+Kempinski+Jakarta',
                'description' => 'Syukuran ramah tamah bersama sanak famili dan sahabat tercinta.',
            ]
        );

        // Invitation Content
        $contents = [
            'groom_name' => 'Andika Pratama, S.Kom',
            'groom_parents' => 'Putra pertama dari Bpk. Bambang Wijaya & Ibu Siti Aminah',
            'groom_instagram' => 'andikapratama',
            'bride_name' => 'Salsabila Putri, S.Ds',
            'bride_parents' => 'Putri kedua dari Bpk. Hendra Gunawan & Ibu Ratna Dewi',
            'bride_instagram' => 'salsabilaputri',
            'quote' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
            'quote_source' => 'QS. Ar-Rum: 21',
            'music_url' => 'https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=romantic-wedding-piano-113004.mp3',
            'music_title' => 'Romantic Wedding Piano',
            'bank_1_name' => 'BCA',
            'bank_1_number' => '5420918273',
            'bank_1_holder' => 'Andika Pratama',
            'bank_2_name' => 'Bank Mandiri',
            'bank_2_number' => '1270009827162',
            'bank_2_holder' => 'Salsabila Putri',
            'gift_address' => 'Jl. Taman Menteng No. 15, Menteng, Jakarta Pusat (Kode Pos: 10310)',
        ];

        foreach ($contents as $k => $v) {
            InvitationContent::updateOrCreate(
                ['invitation_id' => $invitation->id, 'key' => $k],
                ['value' => $v]
            );
        }

        // Invitation Messages / Guestbook
        $messages = [
            ['name' => 'Dimas & Anisa', 'message' => 'Selamat menempuh hidup baru Andika & Salsa! Semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Aamiin! ❤️'],
            ['name' => 'Budi Santoso', 'message' => 'Barakallahu lakuma wa baraka alaikuma wa jama\'a bainakuma fii khair. Turut berbahagia untuk kedua mempelai.'],
            ['name' => 'Nadya Maharani', 'message' => 'Cantik banget Salsa! Selamat ya kalian berdua, langgeng sampai kakek nenek!'],
            ['name' => 'Fajar & Rara', 'message' => 'Semoga dilancarkan acaranya sampai hari H brader Andika! Mantap undangannya keren parah!'],
        ];

        foreach ($messages as $msg) {
            InvitationMessage::updateOrCreate(
                ['invitation_id' => $invitation->id, 'name' => $msg['name']],
                ['message' => $msg['message'], 'is_approved' => true]
            );
        }

        // RSVPs
        InvitationRsvp::updateOrCreate(
            ['invitation_id' => $invitation->id, 'name' => 'Dimas & Anisa'],
            ['attendance' => 'yes', 'total_guests' => 2, 'message' => 'Insya Allah kami hadir tepat waktu.']
        );
        InvitationRsvp::updateOrCreate(
            ['invitation_id' => $invitation->id, 'name' => 'Budi Santoso'],
            ['attendance' => 'yes', 'total_guests' => 1, 'message' => 'Hadir untuk sahabat terbaik!']
        );

        // 8. Seed the Sample Order matching Image 2 (#INV-2024120)
        $order = Order::updateOrCreate(
            ['order_code' => 'INV-2024120'],
            [
                'user_id' => $alfaro->id,
                'total_amount' => 149000,
                'discount_amount' => 0,
                'final_amount' => 149000,
                'status' => 'paid',
                'payment_method' => 'qris',
                'notes' => 'Pesanan Elegance Wedding oleh Alfaro Fadhil',
            ]
        );

        $invitation->update(['order_id' => $order->id]);

        OrderItem::updateOrCreate(
            ['order_id' => $order->id, 'item_type' => 'template', 'item_id' => 1],
            [
                'name' => 'Template Elegance Wedding',
                'quantity' => 1,
                'price' => 149000,
            ]
        );

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'midtrans_transaction_id' => 'QRIS-DETROIT-2024120',
                'method' => 'qris',
                'status' => 'paid',
                'amount' => 149000,
                'paid_at' => Carbon::now()->subMinutes(15),
                'raw_response' => json_encode(['provider' => 'qris', 'status' => 'settlement', 'amount' => 149000]),
            ]
        );

        // Additional demo orders to match the Dashboard in Image 2:
        // Total Pesanan: 245, Pendapatan: Rp 35.750.000
        $recentOrders = [
            ['code' => 'INV-2024119', 'user_name' => 'Rina Kartika', 'phone' => '081388776655', 'amount' => 149000, 'method' => 'bca', 'status' => 'paid', 'template' => 'The Wedding Of Rizky & Dinda', 'time' => now()->subHours(2)],
            ['code' => 'INV-2024118', 'user_name' => 'Ferry Gunawan', 'phone' => '085711223344', 'amount' => 99000, 'method' => 'mandiri', 'status' => 'paid', 'template' => 'Tasyakuran Khitan Ahmad Fathan', 'time' => now()->subHours(5)],
            ['code' => 'INV-2024117', 'user_name' => 'Maya Anggraeni', 'phone' => '087899001122', 'amount' => 149000, 'method' => 'qris', 'status' => 'paid', 'template' => 'Happy Birthday Nayla Turning 8', 'time' => now()->subHours(10)],
            ['code' => 'INV-2024116', 'user_name' => 'Hendrik Pratama', 'phone' => '081299887766', 'amount' => 299000, 'method' => 'gopay', 'status' => 'paid', 'template' => 'Royal Classic Gold Wedding', 'time' => now()->subDay()],
            ['code' => 'INV-2024115', 'user_name' => 'Siti Nurhaliza', 'phone' => '081211223344', 'amount' => 149000, 'method' => 'qris', 'status' => 'pending', 'template' => 'Aqiqah Baby Arka', 'time' => now()->subDays(2)],
            ['code' => 'INV-2024114', 'user_name' => 'Bayu Wicaksono', 'phone' => '081344556677', 'amount' => 99000, 'method' => 'bca', 'status' => 'paid', 'template' => 'The Engagement Rara & Fajar', 'time' => now()->subDays(2)],
        ];

        foreach ($recentOrders as $ro) {
            $u = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $ro['user_name'])) . '@example.com'],
                ['name' => $ro['user_name'], 'phone' => $ro['phone'], 'password' => Hash::make('password')]
            );
            $u->roles()->syncWithoutDetaching([3]);

            $o = Order::updateOrCreate(
                ['order_code' => $ro['code']],
                [
                    'user_id' => $u->id,
                    'total_amount' => $ro['amount'],
                    'discount_amount' => 0,
                    'final_amount' => $ro['amount'],
                    'status' => $ro['status'],
                    'payment_method' => $ro['method'],
                    'created_at' => $ro['time'],
                    'updated_at' => $ro['time'],
                ]
            );

            OrderItem::updateOrCreate(
                ['order_id' => $o->id, 'item_type' => 'template', 'item_id' => 1],
                ['name' => $ro['template'], 'quantity' => 1, 'price' => $ro['amount']]
            );

            if ($ro['status'] === 'paid') {
                Payment::updateOrCreate(
                    ['order_id' => $o->id],
                    [
                        'midtrans_transaction_id' => 'PAY-' . $ro['code'],
                        'method' => $ro['method'],
                        'status' => 'paid',
                        'amount' => $ro['amount'],
                        'paid_at' => $ro['time'],
                    ]
                );
            }
        }
    }
}
