<?php

namespace Tests\Unit\EmailService\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Email;

class EmailTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    /**
     * Add a record without status
     *
     * @test
     */
    public function a_status_default_value_must_be_zero()
    {
        $email = factory(Email::class)->raw();
        unset($email['status']);

        Email::create($email);

        $this->assertCount(1, Email::all());
    }

    /**
     * A basic test checks inserting data to email table.
     *
     * @test
     */
    public function create_a_record()
    {
        // Add a record
        factory(Email::class, 1)->create();

        $this->assertCount(1, Email::all());
    }
}
