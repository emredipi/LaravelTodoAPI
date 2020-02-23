<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Tag::create(["name"=>"Daily"]);
        //factory(App\Tag::class)->create();
    }
}
