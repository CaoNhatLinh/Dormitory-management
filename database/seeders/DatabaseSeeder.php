<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('permissions')->insert([
            'permission_name' => 'admin',
        ]);
        DB::table('positions')->insert([
            'position_name' => 'manager'
           
        ]);
        DB::table('employees')->insert([
            'person_id' => '674264762172',
            'name'=> 'Nguyễn Văn A',
            'gender' => 'Nam',
            'address' => 'Tây Thạnh, Tân Phú',
            'nationality' => 'Việt Nam',
            'date_of_birth' => '2000-1-1',
            'avatar' => 'https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg',
            'position_id' => 1
        ]);
        DB::table('users')->insert([
            'email' => 'admin@gmail.com',
            'employee_id' => 1,
            'permission_id' => 1,
            'password' => Hash::make(123456)
        ]);
       
    }
}
