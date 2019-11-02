<?php

use Illuminate\Database\Seeder;
use App\Models\Tree;

class TreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Tree::create([
            "name" => "Default",
            "data" => [
                    67 => [
                        39 => [
                            28 => [
                                29 => false
                            ],
                            44 => false
                        ],
                        76 => [
                            74 => false,
                            85 => [
                                83 => false,
                                87 => false
                            ]
                        ]
                    ],
            ]
        ]);        
    }
}
