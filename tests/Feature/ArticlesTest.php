<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleTag;
use Illuminate\Http\Response;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    /**
     * Test get articles on main page
     *
     * @return void
     */
    public function test_main_articles()
    {
        $response = $this->get(route('articles.main'));

        $article = Article::query()->latest()->first();

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(config('article.main_count'), 'articles');
        $response->assertJsonFragment([
            'slug' => $article->slug
        ]);
        $response->assertJsonStructure(['status', 'articles']);
    }

    /**
     * Test get list articles
     *
     * @return void
     */
    public function test_list_articles()
    {
        $response = $this->get(route('articles.list'));

        $article = Article::query()->latest()->first();

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(config('pagination.count.articles'), 'data.data');
        $response->assertJsonFragment([
            'slug' => $article->slug
        ]);
        $response->assertJsonStructure(['status', 'data']);
    }

    /**
     * Test get articles by tag
     *
     * @return void
     */
    public function test_list_articles_by_tag()
    {
        $tagName = ArticleTag::query()->inRandomOrder()->first()->name;

        $response = $this->get(route('articles.tag', ['tag' => $tagName]));


        $articlesHasTag = Article::query()->whereHas('tags', function ($q) use ($tagName) {
            $q->where('name', $tagName);
        })->get();
        $articleHasTag = $articlesHasTag->first();

        $articleHasNotTag = Article::query()->whereDoesntHave('tags', function ($q) use ($tagName) {
            $q->where('name', $tagName);
        })->first();


        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'title' => $articleHasTag->title,
            'slug' => $articleHasTag->slug
        ]);
        $response->assertJsonMissing([
            'title' => $articleHasNotTag->title,
            'slug' => $articleHasNotTag->slug,
        ]);
        $response->assertJsonStructure(['status', 'data']);
    }
}
