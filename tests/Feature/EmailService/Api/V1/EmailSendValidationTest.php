<?php

namespace Tests\Feature\Api\EmailService\V1;

use Tests\TestCase;
use App\Models\Email;

class EmailSendValidationTest extends TestCase
{
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
        $response = $this->sendRequest($email);

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
        $response = $this->sendRequest($email);

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
        $response = $this->sendRequest($email);

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
        $response = $this->sendRequest($email);

        // Check failure response is correct
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('content');
    }

    /**
     * Email must has app_id
     *
     * @test
     */
    public function email_without_app_id_is_not_valid()
    {
        // Get sample data and remove content
        $email = $this->getSampleData();
        unset($email['app_id']);

        // Send email request
        $response = $this->sendRequest($email);

        // Check failure response is correct
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('app_id');
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
    public function sendRequest($email)
    {
        $response = $this->json('POST', route('email.service.api.v1.emails.send'), $email);

        return $response;
    }
}
