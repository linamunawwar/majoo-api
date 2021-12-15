<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->id = 1;
        $user->name = 'Admin 1';
        $user->user_name = 'admin1';
        $user->password = Hash::make('admin1');
        $user->created_by =1;
        $user->updated_by =1;
        $user->save();

        $user2 = new User;
        $user2->id = 2;
        $user2->name = 'Admin 2';
        $user2->user_name = 'admin2';
        $user2->password = Hash::make('admin2');
        $user2->created_by =2;
        $user2->updated_by =2;
        $user2->save();
    }
}
