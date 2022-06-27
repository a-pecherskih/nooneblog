<?php

namespace Tests\Feature;

use App\Jobs\AddNewCommentJob;
use App\Models\Article;
use App\Models\Comment;
use App\ModelsDTO\CommentDTO;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * Test show article
     *
     * @return void
     */
    public function test_show_article()
    {
        $article = Article::query()->inRandomOrder()->first()->load(['tags']);
        $commentsCount = Comment::query()->where('article_id', $article->id)->count();

        $response = $this->get(route('article.show', ['article' => $article->slug]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'status',
            'article' => [
                'tags', 'comments'
            ]
        ]);
        $response->assertJsonFragment([
            'slug' => $article->slug,
            'title' => $article->title,
        ]);
        $response->assertJsonCount($article->tags->count(), 'article.tags');
        $response->assertJsonCount($commentsCount, 'article.comments');
    }

    /**
     * Test add new comment to article
     *
     * @return void
     */
    public function test_create_comment()
    {
        Queue::fake();

        $article = Article::query()->inRandomOrder()->first();

        $data = [
            'subject' => "new comment test for {$article->id}",
            'body' => 'This is description',
        ];
        $response = $this->post(route('article.add_comment', ['article' => $article->slug]), $data);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['status']);

        $commentDTO = new CommentDTO($article->slug, $data['subject'], $data['body']);

        Queue::assertPushed(AddNewCommentJob::class, function ($job) use ($commentDTO) {
            return $job->commentDTO->getArticleSlug() == $commentDTO->getArticleSlug()
                && $job->commentDTO->getSubject() == $commentDTO->getSubject();
        });
    }

    /**
     * Test add new comment with empty field
     *
     * @return void
     */
    public function test_create_empty_comment()
    {
        $article = Article::query()->inRandomOrder()->first();

        $data = [
            'subject' => "new comment test for {$article->id}",
            'body' => '',
        ];

        $response = $this->json(
            'POST',
            route('article.add_comment', ['article' => $article->slug]),
            $data
        );

        $response->assertJsonStructure(['success', 'error']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Test increment like
     *
     * @return void
     */
    public function test_increment_like()
    {
        $randomArticle = Article::query()->inRandomOrder()->first();
        $response = $this->get(route('article.show', ['article' => $randomArticle->slug]));
        $articleSlug = $response->json('article.slug');
        $articleLikes = $response->json('article.likes');

        $response = $this->put(route('article.like', ['article' => $articleSlug]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['status', 'likes']);
        $response->assertJsonFragment([
            'likes' => $articleLikes + 1
        ]);
    }

    /**
     * Test increment count_views
     *
     * @return void
     */
    public function test_increment_count_views()
    {
        $randomArticle = Article::query()->inRandomOrder()->first();
        $response = $this->get(route('article.show', ['article' => $randomArticle->slug]));
        $articleSlug = $response->json('article.slug');
        $articleCountViews = $response->json('article.count_views');

        $response = $this->put(route('article.count_views', ['article' => $articleSlug]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['status', 'count_views']);
        $response->assertJsonFragment([
            'count_views' => $articleCountViews + 1
        ]);
    }
}
