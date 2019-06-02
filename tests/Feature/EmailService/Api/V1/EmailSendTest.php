<?php

namespace Tests\Feature\EmailService\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class EmailSendTest extends TestCase
{
    use WithFaker;

    /**
     * Test send email end-point
     *
     * @test
     */
    public function can_send_email()
    {
        $email = $this->getSampleData();

        // Send email request
        $response = $this->json('POST', route('api.email.service.v1.email.send'), $email);

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
        $data = [
            'subject' => $this->faker->sentence,
            'from' => $this->faker->email,
            'fromName' => $this->faker->name,
            'to' => $this->faker->email,
            'toName' => $this->faker->name,
            'contentType' => $this->faker->randomElement(['text/html', 'text/string'])
        ];

        // Add content based on contentType
        if ($data['contentType'] == 'text/html') {

            $data['content'] = $this->faker->randomHtml(1,1);

        } elseif ($data['contentType'] == 'text/string') {

            $data['content'] = $this->faker->paragraph;

        }

        return $data;
    }
}
