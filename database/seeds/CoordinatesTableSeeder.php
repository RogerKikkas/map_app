<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoordinatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coordinates')->insert([
            'user_id' => '1',
            'lat' => 58.363680,
            'lon' => 26.720988,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('coordinates')->insert([
            'user_id' => '1',
            'lat' => 58.359776,
            'lon' => 26.721412,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('coordinates')->insert([
            'user_id' => '2',
            'lat' => 58.369652,
            'lon' => 26.727763,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('coordinates')->insert([
            'user_id' => '2',
            'lat' => 58.368696,
            'lon' => 26.734282,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }}
