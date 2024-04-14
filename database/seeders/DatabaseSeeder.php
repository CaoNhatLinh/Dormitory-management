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
        DB::table('admins')->insert([
            'username' => 'admin1',
            'employee_id' => null,
            'permission_id' => 1,
            'password' => Hash::make(123456)
        ]);
    }
}
