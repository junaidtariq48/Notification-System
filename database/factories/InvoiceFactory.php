<?php

use Faker\Generator as Faker;
use App\Data\Models\Invoice;


$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'invoice_no' => 'INV-'. mt_rand(100000,999999) ,
        'title' => $faker->text,
        'description' => $faker->paragraph,
        'price' => $faker->numberBetween(1,5000),
        'email_address' => $faker->email,
        'due_date' => $faker->dateTimeThisMonth,
        'type' => 'A',
        'landlord_id' => 1,
        'tenant_id' => mt_rand(2,10),
        'status' => 'C',
        'paid' => 0,
        'created_at' => \Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' => \Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s')
    ];
});
