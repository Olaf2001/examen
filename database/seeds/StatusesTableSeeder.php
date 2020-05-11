<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 2 statuses. One for the role author and one for the asignee role
        factory(App\Status::class, 1)->create(['name' => 'author']);
        factory(App\Status::class, 1)->create(['name' => 'asigned']);
    }
}
