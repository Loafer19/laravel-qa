<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 3)->create()->each(function ($u) {
            $u->questions()->saveMany(
                factory(Question::class, rand(1, 3))->make()
            )
            ->each(function ($q) {
                $q->answers()->saveMany(
                    factory(App\Answer::class, rand(2, 5))->make()
                );
            });
        });
    }
}
