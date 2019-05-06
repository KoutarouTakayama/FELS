<?php

use Illuminate\Database\Seeder;

class FelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create();
        factory(App\Category::class, 10)->create();
        factory(App\Word::class, 100)->create();
        factory(App\Relationship::class, 50)->create();
        factory(App\LearnedLesson::class, 20)->create();
        factory(App\LearnedWord::class, 150)->create();
    }
}
