<?php

namespace Tests\Feature\EmailService\Api\V1;

use App\Services\Interfaces\EmailServiceInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Email;
use Illuminate\Support\Facades\Schema;

class EmailSendTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * Test if database connection with emails table lost
     *
     * @test
     */
    public function should_get_error_when_unable_to_save_email()
    {
        // Drop emails table
        Schema::dropIfExists('emails');

        // Get email's sample data
        $email = $this->getSampleData();

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Assert it was successful and response was acceptable
        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ])
            ->assertJson([
                'status' => 'error',
                'message' => 'Unable to communicate with database.'
            ]);
    }

    /**
     * Mock sending email process in order to prevent sending email in real world
     * Get success response when email was sent
     * Email's status must equal to 2 means sent
     *
     * @test
     */
    public function should_get_success_when_email_was_sent()
    {
        // Get sample data
        $email = $this->getSampleData();

        $this->mock(EmailServiceInterface::class, function ($mock){
           $mock->shouldReceive('send')->once()->andReturn(['status' => 'success']);
        });

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Is email saved in database?
        $this->assertCount(1, Email::all());

        // Email's status must be 2 means is sent
        $response->assertSee('sid');
        $responseData = $response->decodeResponseJson('data');
        $this->assertDatabaseHas('emails', [
            'sid' => $responseData['sid'],
            'status' => '2'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'sid'
                ]
            ])
            ->assertJson([
                'status' => 'success',
            ]);
    }

    /**
     * Get fail response when email was not sent
     * Email's status must equal to 3 means not sent
     *
     * @test
     */
    public function should_get_fail_when_email_was_not_sent()
    {
        // Get sample data
        $email = $this->getSampleData();

        $this->mock(EmailServiceInterface::class, function ($mock){
            $mock->shouldReceive('send')->once()->andReturn(['status' => 'fail']);
        });

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Is email saved in database?
        $this->assertCount(1, Email::all());

        // Email's status must be 2 means is sent
        $response->assertSee('sid');
        $responseData = $response->decodeResponseJson('data');
        $this->assertDatabaseHas('emails', [
            'sid' => $responseData['sid'],
            'status' => '3'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'sid'
                ]
            ])
            ->assertJson([
                'status' => 'success',
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
        return $email;
    }
}
