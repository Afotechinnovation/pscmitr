<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        try{

            DB::beginTransaction();

            $this->call(RoleSeeder::class);
            $this->call(AdminSeeder::class);
            $this->call(HighlightSeeder::class);
            $this->call(SettingSeeder::class);
            $this->call(CountriesTableSeeder::class);
            $this->call(StatesTableSeeder::class);
            $this->call(OccupationSeeder::class);

        } catch(\Exception $e) {
            info('error');
            DB::rollback();
        }
    }
}
