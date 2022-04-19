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
        // MessageTableSeederの呼び出し
        $this->call([MessageTableSeeder::class]);
    }
}
