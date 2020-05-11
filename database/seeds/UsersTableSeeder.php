<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 10 random users
        factory(App\User::class, 10)->create();

        // create one test user
        factory(App\User::class, 1)->create(['name' => 'Olaf', 'email' => 'olaf@mail.nl', 'password' => bcrypt('qwerty123')]);
    }
}
