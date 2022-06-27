<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\ArticlesResource;
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
            'articles' => new ArticlesResource($service->getMainArticles())
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
            'data' => new ArticlesResource($service->listArticles())
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
            'data' => new ArticlesResource($service->getArticlesByTag($tag))
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
            'article' => new ArticleResource($article->load(['comments', 'tags']))
        ]);
    }

    /**
     * Increment like column
     *
     * @param Article $article
     * @param ArticleService $service
     * @return JsonResponse
     */
    public function addLike(string $slug, ArticleService $service): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'likes' => $service->addLike($slug)
        ]);
    }

    /**
     * Increment count_views column
     *
     * @param Article $article
     * @param ArticleService $service
     * @return JsonResponse
     */
    public function addCountView(string $slug, ArticleService $service): JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'count_views' => $service->addCountViews($slug)
        ]);
    }
}
