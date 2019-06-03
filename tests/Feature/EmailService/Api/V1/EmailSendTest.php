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
     * @test
     */
    public function success_response_should_have_proper_data()
    {
        // Get sample data
        $email = $this->getSampleData();

        // Mock success
        $this->mock(EmailServiceInterface::class, function ($mock){
            $mock->shouldReceive('send')->once()->andReturn(['status' => 'success']);
        });

        // Send email request
        $response = $this->sendRequest($email);

        // Checking response dat structure
        $response
            ->assertJsonStructure([
                'status',
                'data' => [
                    'subject',
                    'from',
                    'fromName',
                    'to',
                    'toName',
                    'contentType',
                    'content',
                    'sid'
                ]
            ]);
    }

    /**
     * @test
     */
    public function failed_response_should_have_proper_data()
    {
        // Get sample data
        $email = $this->getSampleData();

        // Mock error
        $this->mock(EmailServiceInterface::class, function ($mock){
            $mock->shouldReceive('send')->once()->andReturn(['status' => 'error']);
        });

        // Send email request
        $response = $this->sendRequest($email);

        // Checking response dat structure
        $response
            ->assertJsonStructure([
                'status',
                'data' => [
                    'subject',
                    'from',
                    'fromName',
                    'to',
                    'toName',
                    'contentType',
                    'content',
                    'sid'
                ]
            ]);
    }

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
        $response = $this->sendRequest($email);

        // Assert it was successful and response was acceptable
        $response
            ->assertStatus(422)
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

        // Mock success condition
        $this->mock(EmailServiceInterface::class, function ($mock){
           $mock->shouldReceive('send')->once()->andReturn(['status' => 'success']);
        });

        // Send email request
        $response = $this->sendRequest($email);

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

        // Mock fail condition
        $this->mock(EmailServiceInterface::class, function ($mock){
            $mock->shouldReceive('send')->once()->andReturn(['status' => 'fail']);
        });

        // Send email request
        $response = $this->sendRequest($email);

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

    /**
     * Get email data, send and return response
     *
     * @param $email
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function sendRequest($email)
    {
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        return $response;
    }
}
