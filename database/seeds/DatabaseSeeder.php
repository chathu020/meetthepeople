<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(ClientsTableSeeder::class);
         $this->call(RecipientsTableSeeder::class);
         $this->call(AccommodationTableSeeder::class);
         $this->call(ApprovalPartyTableSeeder::class);
         $this->call(CasereferenceTableSeeder::class);         
    }
}
