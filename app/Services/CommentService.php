<?php

namespace App\Services;

use App\Jobs\AddNewCommentJob;
use App\ModelsDTO\CommentDTO;

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
    public function createComment(string $slug, array $data): void
    {
        $commentDTO = new CommentDTO($slug, $data['subject'], $data['body']);

        AddNewCommentJob::dispatch($commentDTO)->onConnection('database');
    }
}
