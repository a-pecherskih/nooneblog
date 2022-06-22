<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    /**
     * Return last articles
     *
     * @param ArticleService $service
     * @return JsonResponse
     */
    public function mainArticles(ArticleService $service): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'articles' => $service->getMainArticles()
        ]);
    }

    /**
     * Return last articles
     *
     * @param ArticleService $service
     * @return JsonResponse
     */
    public function listArticles(ArticleService $service): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $service->listArticles()
        ]);
    }

    /**
     * Return last articles by tag
     *
     * @param string $tag
     * @param ArticleService $service
     * @return JsonResponse
     */
    public function listByTag(string $tag, ArticleService $service): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $service->getArticlesByTag($tag)
        ]);
    }

    /**
     * Return article
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function show(Article $article): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'article' => $article->load(['comments', 'tags'])
        ]);
    }

    /**
     * Increment like column
     *
     * @param Article $article
     * @param ArticleService $service
     * @return JsonResponse
     */
    public function addLike(Article $article, ArticleService $service): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'likes' => $service->addLike($article)
        ]);
    }

    /**
     * Increment count_views column
     *
     * @param Article $article
     * @param ArticleService $service
     * @return JsonResponse
     */
    public function addCountView(Article $article, ArticleService $service): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'count_views' => $service->addCountViews($article)
        ]);
    }
}
