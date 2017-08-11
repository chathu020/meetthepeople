<?php

use Illuminate\Database\Seeder;
use App\Models\CaseFile;
use Illuminate\Database\Eloquent\Model;

class CasesTableSeeder extends Seeder
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
        		'client_id' => '1',
        		'clientCaseRefHead' => 'cd12',
        		'clientCaseRefTail' => '002',
                'caseRef_id'=> '1',
                'approvedBy_id'=> '2',
                'writer_id'=> '4'

        	],
        	[
        		'client_id' => '2',
        		'clientCaseRefHead' => 'cs13',
        		'clientCaseRefTail' => '001',
                'caseRef_id'=> '1',
                'approvedBy_id'=> '2',
                'writer_id'=> '4'
        	],
        	[
        		'client_id' => '4',
        		'clientCaseRefHead' => 'cs23',
        		'clientCaseRefTail' => '003',
                'caseRef_id'=> '1',
                'approvedBy_id'=> '2',
                'writer_id'=> '4'
        	]
        ];

        foreach ($cases as $key => $value) {
        	CaseFile::create($value);
        }
       
    }
}