<?php

namespace App\Http\Resources\Article;

use App\Helpers\CacheHelper;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticlesResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [];
        $cacheCounts = CacheHelper::getCacheData(config('article.cache_key_counts'));

        foreach ($this->collection as $article) {
            $cacheCountsByArticle = $cacheCounts[$article->slug] ?? [];

            $result[] = [
                'slug' => $article->slug,
                'title' => $article->title,
                'description' => $article->description,
                'likes' => $cacheCountsByArticle['likes'] ?? $article->likes,
                'count_views' => $cacheCountsByArticle['count_views'] ?? $article->count_views,
            ];
        }

        return $result;
    }
}
