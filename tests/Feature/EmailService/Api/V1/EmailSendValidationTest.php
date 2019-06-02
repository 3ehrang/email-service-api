<?php

namespace Tests\Feature\Api\EmailService\V1;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\Email;

class EmailSendValidationTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Email must has subject
     *
     * @test
     */
    public function email_without_subject_is_not_valid()
    {
        // Get sample data and remove subject
        $email = $this->getSampleData();
        unset($email['subject']);

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Check failure response is correct
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('subject');
    }

    /**
     * Email must has receiver mail address
     *
     * @test
     */
    public function email_without_receiver_address_is_not_valid()
    {
        // Get sample data and remove receiver address
        $email = $this->getSampleData();
        unset($email['to']);

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Check failure response is correct
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('to');
    }

    /**
     * Email must has contentType
     *
     * @test
     */
    public function email_without_content_type_is_not_valid()
    {
        // Get sample data and remove contentType
        $email = $this->getSampleData();
        unset($email['contentType']);

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Check failure response is correct
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('contentType');
    }

    /**
     * Email must has content
     *
     * @test
     */
    public function email_without_content_is_not_valid()
    {
        // Get sample data and remove content
        $email = $this->getSampleData();
        unset($email['content']);

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Check failure response is correct
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('content');
    }

    /**
     * @test
     */
    public function email_without_to_name_is_valid()
    {
        // Get sample data and remove content
        $email = $this->getSampleData();
        unset($email['toName']);

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

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
     * @test
     */
    public function email_without_from_name_is_valid()
    {
        // Get sample data and remove content
        $email = $this->getSampleData();
        unset($email['fromName']);

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

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
     * Email's receiver address must be a valid email address
     *
     * @test
     */
    public function receiver_email_format_muse_be_valid()
    {
        // Get sample data
        $email = $this->getSampleData();
        $email['to'] = 'example.co';

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Check failure response is correct
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('to');
    }

    /**
     * Email's receiver address must be a valid email address if provide
     *
     * @test
     */
    public function sender_email_format_muse_be_valid()
    {
        // Get sample data
        $email = $this->getSampleData();
        $email['from'] = 'example.co';

        // Send email request
        $response = $this->json('POST', route('email.service.api.v1.email.send'), $email);

        // Check failure response is correct
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('from');
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
