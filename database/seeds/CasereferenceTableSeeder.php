<?php

use Illuminate\Database\Seeder;
use App\Models\CaseReference;
use Illuminate\Database\Eloquent\Model;

class CasereferenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cases = [
        	[
        		'description' => 'Housing-Sale',
        		'countera' => false
        	],
        	[
        		'description' => 'Housing-Rental',
                'countera' => false
        	],
        	[
        		'description' => 'Housing-SER, MUP, IUP',
                'countera' => false
        	]
            ,
            [
                'description' => 'Citizenship',
                'countera' => false
            ]
            ,
            [
                'description' => 'PR',
                'countera' => false
            ]
            ,
            [
                'description' => 'Work Permit',
                'countera' => false
            ]
            ,
            [
                'description' => 'Contract Marriage',
                'countera' => false
            ]
            ,
            [
                'description' => 'Visa, Visit Pass',
                'countera' => false
            ],
            [
                'description' => 'Parking/Traffic Summons',
                'countera' => false
            ],
            [
                'description' => 'Job',
                'countera' => true
            ],
            [
                'description' => 'Food Stalls',
                'countera' => false
            ],
            [
                'description' => 'Social Welfare/Financial Assistance',
                'countera' => false
            ],
            [
                'description' => 'Utility bills paid by instalmens',
                'countera' => false
            ],
            [
                'description' => 'School & Education Matters',
                'countera' => false
            ],
            [
                'description' => 'National/Reservist Services',
                'countera' => false
            ],
            [
                'description' => 'Environment & TC Matters',
                'countera' => false
            ],
            [
                'description' => 'Dispute - Family/Neighbour',
                'countera' => false
            ],
            [
                'description' => 'Others',
                'countera' => false
            ],           
            [
                'description' => 'Welfare & Social Assistance COM',
                'countera' => true
            ],
            [
                'description' => 'Use of Space',
                'countera' => true
            ]
        ];

        foreach ($cases as $key => $value) {
        	CaseReference::create($value);
        }
       
    }
}