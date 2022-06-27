<?php

namespace App\Http\Resources\Article;

use App\Helpers\CacheHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $cacheCounts = CacheHelper::getCacheData(config('article.cache_key_counts'));
        $cacheCountsByArticle = $cacheCounts[$this->slug] ?? [];

        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'likes' => $cacheCountsByArticle['likes'] ?? $this->likes,
            'count_views' => $cacheCountsByArticle['count_views'] ?? $this->count_views,
            'comments' => $this->comments,
            'tags' => $this->tags
        ];
    }
}
