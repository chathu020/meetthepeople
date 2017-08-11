<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,3000) as $index) {
            DB::table('clients')->insert([
                'nric' => $faker->unique()->randomNumber(5),
                'name' => $faker->name,
                'color' => $faker->boolean(),
                'address' => $faker->city,
                'sex' => $faker->boolean(),
                'accomodationType' => $faker->boolean(),
                'status' => $faker->boolean(),
                
            ]);
        }
    }
}