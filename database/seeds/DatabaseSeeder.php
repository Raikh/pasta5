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
        \App\Linguist::insert([
                'name' => 'php'
                ]);
        \App\Linguist::insert([
                'name' => 'javascript'
                ]);
        \App\Linguist::insert([
                'name' => 'html'
                ]);

        \App\Accesstime::insert([
                'name'=>'10 min',
                'value'=>'600'
                ]);
        \App\Accesstime::insert([
                'name'=>'1 hr',
                'value'=>'3600'
                ]);
        \App\Accesstime::insert([
                'name'=>'3 hr',
                'value'=>'10800'
                ]);
        \App\Accesstime::insert([
                'name'=>'1 day',
                'value'=>'86400'
                ]);
        \App\Accesstime::insert([
                'name'=>'1 week',
                'value'=>'604800'
                ]);
        \App\Accesstime::insert([
                'name'=>'1 month',
                'value'=>'2419200'
                ]);

        // $this->call(UsersTableSeeder::class);
    }
}
