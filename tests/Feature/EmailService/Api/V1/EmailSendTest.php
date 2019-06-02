<?php

namespace Tests\Feature\EmailService\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Email;

class EmailSendTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;
    /**
     * Test send email end-point
     *
     * @test
     */
    public function can_send_email()
    {
        $email = $this->getSampleData();

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Is email saved in database?
        $this->assertCount(1, Email::all());

        // Assert it was successful and response was acceptable
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ])
            ->assertJson([
                'status' => 'success',
                'message' => 'Queued. Thank you.',
            ]);
    }

    /**
     * Provide simple sending email data
     *
     * @return array
     */
    public function getSampleData()
    {
        $email = factory(Email::class)->raw()['data'];
        return json_decode($email, true);
    }
}
