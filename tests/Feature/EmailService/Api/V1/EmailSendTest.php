<?php

namespace Tests\Feature\EmailService\Api\V1;

use App\Jobs\ProcessSaveEmail;
use App\Jobs\ProcessSendEmail;
use App\Services\Email\EmailService;
use App\Services\Email\EmailServiceInterface;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Email;
use Illuminate\Support\Facades\Queue;

class EmailSendTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

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

        // Mock queue
        Queue::fake();

        // Send email request to endpoint
        $response = $this->json('POST', route('email.service.api.v1.emails.send'), $email);

        // Assert a job was pushed to saveEmail queue
        Queue::assertPushedOn('saveEmail', ProcessSaveEmail::class);

        // Assert a job was pushed just once
        Queue::assertPushed(ProcessSaveEmail::class, 1);

        // Perform save email
        Queue::assertPushed(ProcessSaveEmail::class, function ($saveJob) use ($email) {

            return $saveJob->data['data']['to'] === $email['to'];

        });

        // Assert a job was pushed to sendEmail queue
        Queue::assertPushedOn('sendEmail', ProcessSendEmail::class);

        // Assert a job was pushed just once
        Queue::assertPushed(ProcessSendEmail::class, 1);

        // Check send email data
        Queue::assertPushed(ProcessSendEmail::class, function ($sendJob) use ($email) {
            return $sendJob->data->to === $email['to'];
        });

        return $response;
    }
}
