<?php

use Illuminate\Database\Seeder;
use App\User;

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

        // create one test user with the role admin
        factory(App\User::class, 1)->create(['name' => 'Olaf', 'email' => 'olaf@mail.nl', 'password' => bcrypt('qwerty123')])
            ->each(function (User $user) {
                $user->assignRole('admin');
            });

        // create one test user with the role admin
        factory(App\User::class, 1)->create(['name' => 'Robert', 'email' => 'robert@mail.nl', 'password' => bcrypt('qwerty123')])
        ->each(function (User $user) {
            $user->assignRole('user');
        });
    }
}
