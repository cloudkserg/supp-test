<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use Carbon\Carbon;
use App\Type\DemandStatus;
use App\Type\DemandItemStatus;

/**
 * Company
 */

$factory->define(App\Company::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->company
    ];
});


$factory->define(App\User::class, function (Faker\Generator $faker) use ($factory) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'confirmed' => true,
        'company_id' => $faker->randomElement(\App\Company::pluck('id')->toArray())
    ];
});

$factory->defineAs(App\User::class, 'stub', function (Faker\Generator $faker) use ($factory) {
    return [
        'name' => $faker->name,
        'email' => env('MAIL_ADMIN', $faker->safeEmail),
        'password' => bcrypt(str_random(10)),
        'confirmed' => false,
    ];
});

$factory->defineAs(App\User::class, 'confirmating', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, [
        'confirmed' => false,
        'confirmation_code' => str_random(\App\Services\UserService::CONFIRMATION_LENGTH)
    ]);
});

/**
 * Type
 */


$factory->define(\App\Type\Quantity::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->title
    ];
});

$factory->define(\App\Type\Region::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->title
    ];
});

$factory->define(\App\Type\Sphere::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->title
    ];
});

$factory->define(\App\Message::class, function (\Faker\Generator $faker) {
   return [
        'text' => $faker->title,
        'status' => \App\Type\MessageStatus::ACTIVE
   ];
});

/**
 * Demand
 */

$factory->define(App\Demand\Demand::class, function (Faker\Generator $faker) {
   return [
       'title' => $faker->optional()->title,
       'desc' => $faker->text,
       'address' => $faker->address,
       'number' => $faker->randomDigit,
       'status' => DemandStatus::ACTIVE,
       'delivery_date' => Carbon::parse($faker->date),
       'company_id' => $faker->randomElement(\App\Company::pluck('id')->toArray()),
       'addition_emails' => $faker->shuffleArray([
           $faker->safeEmail,
           $faker->safeEmail
       ]),
   ];
});

$factory->define(\App\Demand\DemandItem::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->title,
        'count' => $faker->randomFloat(),
        'quantity_id' => $faker->randomElement(\App\Type\Quantity::pluck('id')->toArray()),
        'demand_id' => $faker->randomElement(\App\Demand\Demand::pluck('id')->toArray()),
        'response_item_id' => $faker->optional()->randomElement(\App\Demand\ResponseItem::pluck('id')->toArray()),
    ];
});


$factory->define(App\Demand\Response::class, function (Faker\Generator $faker) {
    return [
        'number' => $faker->randomDigit,
        'status' => $faker->randomElement((new \App\Type\ResponseStatus())->getValues()),
        'company_id' => $faker->randomElement(\App\Company::pluck('id')->toArray()),
        'demand_id' => $faker->randomElement(\App\Demand\Demand::pluck('id')->toArray()),
        'delivery_type' => $faker->text
    ];
});


$factory->define(\App\Demand\ResponseItem::class, function (Faker\Generator $faker) {
   return [
       'price_raw' => $faker->numberBetween(0, 1000),
       'response_id' => $faker->randomElement(\App\Demand\Response::pluck('id')->toArray()),
       'demand_item_id' => $faker->randomElement(\App\Demand\DemandItem::pluck('id')->toArray()),
   ];
});

$factory->define(\App\Demand\Invoice::class, function (Faker\Generator $faker) {
    return [
        'status' => \App\Type\InvoiceStatus::REQUESTED,
        'response_id' => $faker->randomElement(\App\Demand\Response::pluck('id')->toArray())
    ];
});
