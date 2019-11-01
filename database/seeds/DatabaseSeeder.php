<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            "trees",
        ]);
        $this->call(TreeSeeder::class);
    }
    /**
     * Trunca todas las tablas enviadas en el array
     * @param array $tables Array con los nombres de las tablas a truncar.
     */
    protected function truncateTables(array $tables){
        DB::statement("SET FOREIGN_KEY_CHECKS=0");
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement("SET FOREIGN_KEY_CHECKS=1");        
    }    
}
