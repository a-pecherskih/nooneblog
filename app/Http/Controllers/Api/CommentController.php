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
    public function save(string $slug, StoreCommentRequest $request, CommentService $service): JsonResponse
    {
        $inputs = $request->only(['subject', 'body']);

        $service->createComment($slug, $inputs);

        return response()->json([
            'status' => Response::HTTP_OK
        ]);
    }
}
