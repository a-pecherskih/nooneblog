<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Database\Seeder;

class ArticleTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ArticleTag::factory()->count(15)->create();

        Article::all()->each(function ($article) use ($tags) {
           $article->tags()->attach($tags->random(rand(1, 5))->pluck('id'));
        });
    }
}
