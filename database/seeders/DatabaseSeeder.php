<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Convenience_store;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Convenience_store::create([
            'name'=>"コンビニ",
            'lat'=>36.56840310000000000000,
            'lng'=>140.63959740000000000000,
            'check'=>0,
        ]);
        Comment::create([
            'convenienceID'=>1,
            'comment'=>'吸いやすい',
        ]);
        Comment::create([
            'convenienceID'=>1,
            'comment'=>'灰皿が綺麗',
        ]);
    }
}
