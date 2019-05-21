<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => bcrypt('secret'),
            'color' => 'red',
            //'api_token' => Str::random(10),
            'api_token' => 'test62',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
