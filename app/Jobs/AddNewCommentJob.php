<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\Comment;
use App\ModelsDTO\CommentDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddNewCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var CommentDTO
     */
    public CommentDTO $commentDTO;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CommentDTO $commentDTO)
    {
        $this->commentDTO = $commentDTO;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(600);

        $this->createComment($this->commentDTO);
    }

    /**
     * Create comment
     *
     * @param CommentDTO $commentDTO
     */
    private function createComment(CommentDTO $commentDTO)
    {
        $article = Article::query()
            ->where('slug', $commentDTO->getArticleSlug())
            ->first();
        if (is_null($article)) return;

        Comment::query()->create([
            'created_at' => $commentDTO->getDate()->format('Y-m-d'),
            'subject' => $commentDTO->getSubject(),
            'body' => $commentDTO->getBody(),
            'article_id' => $article->id,
        ]);
    }
}
