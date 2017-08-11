<?php

use Illuminate\Database\Seeder;
use App\Models\Approvalparty;
use Illuminate\Database\Eloquent\Model;

class ApprovalPartyTableSeeder extends Seeder
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
        		'authorizedName' => 'Denise Phua',
        		'designation' => 'MP for Jalan Besar GRC'
        	],
        	[
        		'authorizedName' => 'Dr Lee Boon Yang',
        		'designation' => 'MP for Jalan Besar GRC'        		
        	],
        	[
                'authorizedName' => 'Koh Poh Kwang',
                'designation' => 'Chairman, Whampoa CCC'               
            ],
            [
                'authorizedName' => 'Dr Lily Neo',
                'designation' => 'MP for Jalan Besar GRC'               
            ],
            [
                'authorizedName' => 'Heng Chee How',
                'designation' => 'MP for Jalan Besar GRC'               
            ],
            [
                'authorizedName' => 'Lee Boon Yang',
                'designation' => 'MP for Jalan Besar GRC'               
            ],
            [
                'authorizedName' => 'Lily Neo',
                'designation' => 'MP for Jalan Besar GRC'               
            ],
            [
                'authorizedName' => 'Loh Meng See',
                'designation' => 'MP for Jalan Besar GRC'               
            ],
            [
                'authorizedName' => 'Yaacob Ibrahim',
                'designation' => 'MP for Jalan Besar GRC'               
            ],

        ];

        foreach ($parties as $key => $value) {
        	Approvalparty::create($value);
        }
       
    }
}