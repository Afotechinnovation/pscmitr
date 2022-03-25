<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $occupation = new Occupation();
        $occupation->name = 'Student';
        $occupation->save();

        $occupation = new Occupation();
        $occupation->name = 'Teacher';
        $occupation->save();

        $occupation = new Occupation();
        $occupation->name = 'Developer';
        $occupation->save();

        $occupation = new Occupation();
        $occupation->name = 'Employed';
        $occupation->save();

    }
}
