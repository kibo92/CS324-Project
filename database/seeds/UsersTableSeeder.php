<?php
 
use Illuminate\Database\Seeder;
 
class UsersTableSeeder extends Seeder {
 
    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('users')->delete();
 
        $users = array(
            ['id' => 1, 'name' => 'Boris Lukovic', 'email' => 'borislukovic@outlook.com', 'password' => sha1('adminpassword'), 'api_token' => str_random(60), 'account_type' => 'admin', 'created_at' => new DateTime, 'updated_at' => new DateTime]);
     
        //// Uncomment the below to run the seeder
        DB::table('users')->insert($users);
    }
 
}