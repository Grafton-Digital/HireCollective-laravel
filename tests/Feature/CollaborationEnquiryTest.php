<?php

namespace Tests\Feature;

use App\Mail\CollaborationEnquiryMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CollaborationEnquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_collaboration_enquiry_sends_email_to_admin(): void
    {
        Mail::fake();

        $response = $this->postJson('/collaboration', [
            'name' => 'John Doe',
            'company' => 'Acme Corp',
            'email' => 'john@example.com',
            'message' => 'I would love to collaborate with you on a project.',
        ]);

        $response->assertOk();

        Mail::assertSent(CollaborationEnquiryMail::class, function ($mail) {
            return $mail->hasTo(config('app.admin_email'))
                && $mail->name === 'John Doe'
                && $mail->email === 'john@example.com'
                && $mail->company === 'Acme Corp'
                && $mail->enquiryMessage === 'I would love to collaborate with you on a project.';
        });
    }

    public function test_collaboration_enquiry_works_without_company(): void
    {
        Mail::fake();

        $response = $this->postJson('/collaboration', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'Interested in collaboration.',
        ]);

        $response->assertOk();

        Mail::assertSent(CollaborationEnquiryMail::class);
    }

    public function test_collaboration_enquiry_validates_required_fields(): void
    {
        $response = $this->postJson('/collaboration', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'message']);
    }

    public function test_collaboration_enquiry_validates_email_format(): void
    {
        $response = $this->postJson('/collaboration', [
            'name' => 'John',
            'email' => 'not-an-email',
            'message' => 'Hello',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }
}
