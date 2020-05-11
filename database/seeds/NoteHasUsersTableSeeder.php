<?php

use Illuminate\Database\Seeder;

class NoteHasUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 20 random noteHasUsers
        factory(App\NoteHasUser::class, 20)->create();
    }
}
