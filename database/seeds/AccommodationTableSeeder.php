<?php

use Illuminate\Database\Seeder;
use App\Models\Accomodation;
use Illuminate\Database\Eloquent\Model;

class AccommodationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parties = [
        	[
        		'accomodation' => 'HDB',
        		'roomType' => '1-room'
        	],
        	[
        		'accomodation' => 'HDB',
        		'roomType' => '2-room'
        	],
        	[
        		'accomodation' => 'HDB',
        		'roomType' => '3-room'
        	],
            [
        		'accomodation' => 'HDB',
        		'roomType' => '4-room'
        	],
            [
        		'accomodation' => 'HDB',
        		'roomType' => '5-room'
        	],
            [
        		'accomodation' => 'HDB',
        		'roomType' => 'Executive'
        	],
        	[
        		'accomodation' => 'Private',
        		'roomType' => 'High Rise'
        	],
        	[
        		'accomodation' => 'Private',
        		'roomType' => 'Landed Property'
        	],
        	[
        		'accomodation' => 'Private',
        		'roomType' => 'Shophouse/Factory'
        	],
        	[
        		'accomodation' => 'Private',
        		'roomType' => 'Others'
        	],

        ];

        foreach ($parties as $key => $value) {
        	Accomodation::create($value);
        }
       
    }
}