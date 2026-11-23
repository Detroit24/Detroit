<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Template;
use App\Models\Invitation;
use App\Models\InvitationEvent;
use App\Models\InvitationContent;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DetroitWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test Landing Page
     */
    public function test_landing_page_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('DETROIT');
        $response->assertSee('Digital');
        $response->assertSee('Pilihan Template Terbaik');
        $response->assertSee('Paket Harga');
    }

    /**
     * Test Order Flow
     */
    public function test_order_and_checkout_workflow()
    {
        $template = Template::first();

        // 1. Visit checkout page
        $response = $this->get('/pesan?template=' . $template->slug);
        $response->assertStatus(200);
        $response->assertSee('Data Pesanan');

        // 2. Submit order form
        $postData = [
            'template_id' => $template->id,
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '081388776655',
            'customer_email' => 'budi.unique@email.com',
            'event_title' => 'The Wedding Of Budi & Santi',
            'event_date' => '2026-12-14',
            'groom_name' => 'Budi',
            'bride_name' => 'Santi',
            'event_location' => 'Jakarta',
        ];

        $storeResponse = $this->post('/pesan', $postData);
        $storeResponse->assertStatus(302);

        $order = Order::latest()->first();
        $this->assertNotNull($order);

        // 3. Visit payment page
        $paymentResponse = $this->get('/pembayaran/' . $order->order_code);
        $paymentResponse->assertStatus(200);
        $paymentResponse->assertSee('Pilih Metode Pembayaran');
        $paymentResponse->assertSee('QRIS');

        // 4. Confirm payment
        $confirmResponse = $this->post('/pembayaran/' . $order->order_code . '/konfirmasi', [
            'payment_method' => 'qris',
        ]);
        $confirmResponse->assertRedirect(route('order.success', $order->order_code));

        $order->refresh();
        $this->assertEquals('paid', $order->status);

        // 5. Success screen with WhatsApp preview
        $successResponse = $this->get('/pesanan-berhasil/' . $order->order_code);
        $successResponse->assertStatus(200);
        $successResponse->assertSee('Pembayaran Berhasil');
        $successResponse->assertSee('Link Undangan Anda');
        $successResponse->assertSee('Terima kasih telah memesan');
    }

    /**
     * Test Live Digital Invitation
     */
    public function test_invitation_view_and_rsvp()
    {
        $user = User::where('email', 'admin@detroit.id')->first();
        $this->assertNotNull($user);

        $invitation = Invitation::create([
            'user_id' => $user->id,
            'template_id' => Template::first()->id,
            'package_id' => null,
            'slug' => 'budi-santoso-123',
            'title' => 'The Wedding Of Budi & Santi',
            'status' => 'published',
            'starts_at' => now(),
            'published_at' => now(),
        ]);

        InvitationEvent::create([
            'invitation_id' => $invitation->id,
            'event_name' => 'Akad Nikah',
            'event_date' => '2026-12-14',
            'event_time' => '08:00:00',
            'location' => 'Jakarta',
            'description' => 'Momen sakral ijab kabul.',
        ]);

        foreach ([
            'groom_name' => 'Budi Santoso',
            'bride_name' => 'Santi Larasati',
            'quote' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri.',
            'quote_source' => 'QS. Ar-Rum: 21',
        ] as $key => $value) {
            InvitationContent::create([
                'invitation_id' => $invitation->id,
                'key' => $key,
                'value' => $value,
            ]);
        }

        $response = $this->get('/invitation/' . $invitation->slug . '?to=Budi+Santoso');
        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertSee('Mempelai Bahagia');

        // Test RSVP submission
        $rsvpResponse = $this->post('/invitation/' . $invitation->slug . '/rsvp', [
            'name' => 'Budi Santoso',
            'attendance' => 'yes',
            'total_guests' => 2,
            'message' => 'Selamat untuk kedua mempelai!',
        ]);
        $rsvpResponse->assertStatus(302);

        // Test Guestbook message submission
        $msgResponse = $this->post('/invitation/' . $invitation->slug . '/ucapan', [
            'name' => 'Sahabat Terbaik',
            'message' => 'Semoga sakinah mawaddah warahmah!',
        ]);
        $msgResponse->assertStatus(302);
    }

    /**
     * Test Admin Dashboard & Auth
     */
    public function test_admin_access_and_dashboard()
    {
        // Unauthenticated access redirects to login
        $guestResponse = $this->get('/admin');
        $guestResponse->assertRedirect('/login');

        // Login as Admin
        $admin = User::where('email', 'admin@detroit.id')->first();
        $this->actingAs($admin);

        $dashboardResponse = $this->get('/admin');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Dashboard');
        $dashboardResponse->assertSee('Total Pesanan');
        $dashboardResponse->assertSee('Grafik Penjualan');
        $dashboardResponse->assertSee('Pesanan Terbaru');
    }

    /**
     * Test Demo Templates Render (Elegance Wedding & Wedding Rizky Dinda)
     */
    public function test_template_demos_render()
    {
        $response1 = $this->get('/demo/elegance-wedding?to=Tamu+Undangan');
        $response1->assertStatus(200);
        $response1->assertSee('Aulia');
        $response1->assertSee('Rama');

        $response2 = $this->get('/demo/wedding-rizky-dinda?to=Sahabat+Tercinta');
        $response2->assertStatus(200);
        $response2->assertSee('Rizky');
        $response2->assertSee('Dinda');
        $response2->assertSee('Sahabat Tercinta');
        $response2->assertSee('Mempelai Bahagia');
    }
}
