<?php

namespace Tests\Feature\EmailService\Api\V1;

use App\Jobs\ProcessSaveEmail;
use App\Jobs\ProcessSendEmail;
use App\Services\Interfaces\EmailServiceInterface;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Email;
use Illuminate\Support\Facades\Schema;

class EmailSendTest extends TestCase
{
    //use DatabaseMigrations, RefreshDatabase;

    /**
     * @test
     */
    public function success_response_should_have_proper_data()
    {
        $response = $this->sendFakeBusRequest();

        // Checking response dat structure
        $response
            ->assertJsonStructure([
                'status',
                'data' => [
                    'sid',
                    'received' => [
                        'subject',
                        'from',
                        'fromName',
                        'to',
                        'toName',
                        'contentType',
                        'content',
                    ]
                ]
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
        $response = $this->sendFakeBusRequest();

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
        $email = factory(Email::class)->raw();
        $data = $email['data'];
        $data['app_id'] = $email['app_id'];

        return $data;
    }

    /**
     * Get email data, send and return response
     *
     * @param $email
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function sendFakeBusRequest()
    {
        // Get sample data
        $email = $this->getSampleData();

        // Mock our jobs
        Bus::fake();

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Check save email job
        Bus::assertDispatched(ProcessSaveEmail::class, function ($saveJob) use ($email) {
            return $saveJob->data['data']['to'] === $email['to'];
        });

        // Check send email data
        Bus::assertDispatched(ProcessSendEmail::class, function ($sendJob) use ($email) {
            return $sendJob->data['to'] === $email['to'];
        });

        return $response;
    }
}
