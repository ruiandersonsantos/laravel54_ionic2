<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\CodeFlix\Models\Plan::class,1)->states(
            \CodeFlix\Models\Plan::DURATION_MOTHLY
        )->create();

        factory(\CodeFlix\Models\Plan::class,1)->states(
            \CodeFlix\Models\Plan::DURATION_YEARLY
        )->create();
    }
}
