<?php

namespace App\Services;

use App\Jobs\AddNewCommentJob;
use App\Models\Comment;
use Carbon\Carbon;

/**
 * Class CommentService
 * @package App\Services
 */
class CommentService
{
    /**
     * Create comment
     *
     * @param int $articleId
     * @param array $data
     */
    public function createComment(int $articleId, array $data): void
    {
        $commentData = [
            'created_at' => Carbon::now(),
            'subject' => $data['subject'],
            'body' => $data['body'],
            'article_id' => $articleId,
        ];

        AddNewCommentJob::dispatch($commentData)->onConnection('database');
    }
}
