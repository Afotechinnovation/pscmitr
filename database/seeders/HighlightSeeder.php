<?php

namespace Database\Seeders;

use App\Models\Highlight;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HighlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('highlights')->truncate();

        $highlights = [
            [
                "title" => 'Test Only',
            ],
            [
                "title" => 'Test + Videos',
            ],
            [
                "title" => 'Previous Question Papers',
            ],
            [
                "title" => 'Solved Answer Sheet',
            ],
            [
                "title" => 'Popular Videos',
            ]
        ];

        foreach ($highlights as $highlight) {
            Highlight::create($highlight);
        }
    }
}
