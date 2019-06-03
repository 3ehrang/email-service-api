<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Email;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Email::class, function (Faker $faker) {

    /*
     * Create receive email data
     */
    $data = [
        'subject' => $faker->sentence,
        'from' => $faker->email,
        'fromName' => $faker->name,
        'to' => $faker->email,
        'toName' => $faker->name,
        'contentType' => $faker->randomElement(['text/html', 'text/string'])
    ];

    // Add content based on contentType
    if ($data['contentType'] == 'text/html') {

        $data['content'] = $faker->randomHtml(1,1);

    } elseif ($data['contentType'] == 'text/string') {

        $data['content'] = $faker->paragraph;

    }

    return [
        'sid' => 'sid-' . now()->format('ymds') . $faker->randomNumber(5),
        'status' => $faker->numberBetween(0, 3),
        'data' => $data,
        'received_at' => now()->addSeconds(30),
        'sent_at'   => now()->addSeconds(60),
    ];
});
