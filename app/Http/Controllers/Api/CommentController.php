<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Article;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Save comment
     *
     * @param Article $article
     * @param StoreCommentRequest $request
     * @param CommentService $service
     * @return JsonResponse
     */
    public function save(Article $article, StoreCommentRequest $request, CommentService $service): JsonResponse
    {
        $inputs = $request->only(['subject', 'body']);

        $service->createComment($article->id, $inputs);

        return response()->json([
            'status' => Response::HTTP_OK
        ]);
    }
}
