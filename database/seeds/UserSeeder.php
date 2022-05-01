<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Usuario Admin
        DB::table('users')->insert([
            'name' => 'Mario Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin1234'),
            'role' => '1',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        //Usuario Cliente
        DB::table('users')->insert([
            'name' => 'Juan Cliente',
            'email' => 'cliente@mail.com',
            'password' => bcrypt('cliente123'),
            'role' => '2',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
