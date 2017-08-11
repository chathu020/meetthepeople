<?php

use Illuminate\Database\Seeder;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\Model;

class RecipientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipients = [
        	[
        		'organization' => 'Association of Muslim Professionals',
        		'address' => 'AMP @ Pasir Ris
1 Pasir Ris Drive 4, #05-11
Singapore 519457',
                'attention' => 'General Manager'
        	],
        	[
                'organization' => 'HQ 5th SINGAPORE INFANTRY BRIGADE',
                'address' => 'AFPN 1002
#03-06/07 Jurong Camp
Singapore 638358',
                'attention' => 'COMMANDER'
            ],
            [
                'organization' => '1st Signal Battalion',
                'address' => 'AFPN 1194
208 Gombak Drive
Hill View Camp',
                'attention' => ''
            ]
            ,
            [
                'organization' => '2 PDF',
                'address' => '2 PDF
NSHRC c/o AFPN 5084
26 Clementi Loop #01-36
Training Centre Block
Singapore (129817)',
                'attention' => ''
            ]
            ,
            [
                'organization' => '464 Singapore Armour Regiment',
                'address' => 'AFPN 1512
BLK 252 #03-12
Sungei Gedong Road
Singapore 718923',
                'attention' => 'CPT Lee Say Teck'
            ]
            

        ];

        foreach ($recipients as $key => $value) {
        	Recipient::create($value);
        }
       
    }
}