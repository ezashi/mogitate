<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seasons = ['春', '夏', '秋', '冬'];

        foreach ($seasons as $name) {
        \App\Models\Season::create(['name' => $name]);
        }
    }
}