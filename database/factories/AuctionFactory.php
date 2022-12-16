<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Domain;
use App\Models\Admin\Auction;
use Faker\Generator as Faker;

$factory->define(Auction::class, function (Faker $faker) {
    $domain = Domain::all()->random()->domain;
    $days = $faker->numberBetween(1,62);
    $start_price = $faker->numberBetween(500000,900000);
    $end_price = $faker->numberBetween(10000,300000);
    $steps = $faker->numberBetween(1,$days);
    $auction_area = $start_price - $end_price;
    $average_per_day = $auction_area/$days;
    $day_intervel = $faker->numberBetween(7,14);
    $start_date = \Carbon\Carbon::now()->addDay($day_intervel);
    $end_date = \Carbon\Carbon::now()->addDay($day_intervel+$days);
    $status = $faker->numberBetween(1,4);
    return [
        'domain' => $domain,
        'start_price' => $start_price,
        'end_price' => $end_price,
        'days' => $days,
        'steps' => $steps,
        'auction_area' => $auction_area,
        'average_per_day' => $average_per_day,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'status' => $status,
    ];
});
