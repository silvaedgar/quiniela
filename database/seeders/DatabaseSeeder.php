<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Stadiums;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); // Desactivamos la revisión de claves foráneas
        // DB::table('prediction_details')->truncate();
        // DB::table('predictions')->truncate();
        // DB::table('matchups')->truncate();
        // DB::table('teams')->truncate();
        // DB::table('config')->truncate();
        // DB::table('stadiums')->truncate();
        // DB::table('users')->truncate();

        // DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); // Reactivamos la revisión de claves foráneas
        $this->call([RoleSeeder::class]);
        $this->call([UsersTableSeeder::class]);
        $this->call([ConfigSeeder::class]);

        \App\Models\Team::factory(32)->create();
        $this->call([StadiumSeeder::class]);
        $this->call([MatchupSeeder::class]);

    }
}
