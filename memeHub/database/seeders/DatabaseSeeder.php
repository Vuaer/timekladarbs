<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create(array('name' => 'Wolf',
                   'email' => 'wolf@memehub.test', 
                   'password' => bcrypt('wolf@memehub.test')
        ));
        User::create(array('name' => 'Jack',
                   'email' => 'jack@memehub.test', 
                   'password' => bcrypt('jack@memehub.test')
        ));

    }
}
