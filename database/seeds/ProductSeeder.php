<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Productos
        DB::table('products')->insert([
            'nombre' => 'Agua Bonafont 1 Lt',
            'precio' => '10.50',
            'impuesto' => '5',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('products')->insert([
            'nombre' => 'Takis fuego',
            'precio' => '15.00',
            'impuesto' => '10',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('products')->insert([
            'nombre' => 'Rockaleta',
            'precio' => '7.00',
            'impuesto' => '3',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('products')->insert([
            'nombre' => 'Arroz 500 gr',
            'precio' => '33.00',
            'impuesto' => '13',
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('products')->insert([
            'nombre' => 'Jugo de mango',
            'precio' => '17.00',
            'impuesto' => '6',
            'created_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
