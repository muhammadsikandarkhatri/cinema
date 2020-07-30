<?php

use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return factory(App\Film::class, 5)->create()->each(function ($film) {
            $film->genres()->save(factory(App\Genre::class)->make());
        });
    }
}
