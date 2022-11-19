<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@quiniela.com',
            'email_verified_at' => now(),
            'password' => Hash::make('1234568'),
            'status' => 'Activo',
            'created_at' => now(),
            'updated_at' => now(),
        ])->assignRole('Admin');

        User::factory(20)->create();
    }
}
