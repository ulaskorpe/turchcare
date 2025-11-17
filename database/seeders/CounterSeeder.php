<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Counter;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CounterSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // 30 gün geriye doğru git
        for ($day = 0; $day < 30; $day++) {

            $date = Carbon::today()->subDays($day);

            // Her gün 10-100 kayıt
            $recordsPerDay = rand(10, 100);

            for ($i = 0; $i < $recordsPerDay; $i++) {

                Counter::create([
                    'ip_address' => $faker->ipv4,
                    'country'    => $faker->country,
                    'city'       => $faker->city,
                    'count'      => rand(1, 5),
                    'date'       => $date->toDateString(),
                ]);
            }
        }
    }
}
