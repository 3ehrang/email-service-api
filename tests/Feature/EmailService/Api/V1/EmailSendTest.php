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
    public function can_not_save_email_into_database()
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
     *
     * @test
     */
    public function can_send_email()
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
     * Mock sending email process and check email sending failure
     *
     * @test
     */
    public function can_not_send_email()
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
