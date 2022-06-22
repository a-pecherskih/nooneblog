<?php

namespace App\Services;

use App\Helpers\CacheHelper;
use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class ArticleService
 * @package App\Services
 */
class ArticleService
{
    /**
     * Return articles to main page
     *
     * @return Collection
     */
    public function getMainArticles(): Collection
    {
        return Article::query()
            ->miniatures()
            ->latest()
            ->limit(config('article.main_count'))
            ->get();
    }

    /**
     * Return last articles
     *
     * @return LengthAwarePaginator
     */
    public function listArticles(): LengthAwarePaginator
    {
        return Article::query()
            ->miniatures()
            ->latest()
            ->paginate(config('pagination.count.articles'));
    }

    /**
     * Return articles where has tag
     *
     * @param string $tag
     * @return mixed
     */
    public function getArticlesByTag(string $tag)
    {
        return Article::query()
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('name', $tag);
            })
            ->miniatures()
            ->latest()
            ->paginate(config('pagination.count.articles'));
    }

    /**
     * Increment like
     *
     * @param Article $article
     * @return int
     */
    public function addLike(string $slug): int
    {
        return $this->incrementCountColumn($slug, 'likes');
    }

    /**
     * Increment count_views
     *
     * @param Article $article
     * @return int
     */
    public function addCountViews(string $slug): int
    {
        return $this->incrementCountColumn($slug, 'count_views');
    }

    /**
     * Add value to cache
     *
     * @param string $slug
     * @param string $columnName
     * @return int
     */
    private function incrementCountColumn(string $slug, string $columnName): int
    {
        $cacheKey = config('article.cache_key_counts');

        $articles = CacheHelper::getCacheData($cacheKey) ?? [];

        if (isset($articles[$slug][$columnName])) {
            $articles[$slug][$columnName] += 1;
            $count = $articles[$slug][$columnName];
        } else {
            $article = Article::query()
                ->where(['slug' => $slug])
                ->firstOrFail();

            $count = ++$article->$columnName;

            $articles[$slug]['likes'] = $article->likes;
            $articles[$slug]['count_views'] = $article->count_views;
        }

        CacheHelper::setCacheData($cacheKey, $articles);

        return $count;
    }
}
