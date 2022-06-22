<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
    public function addLike(Article $article): int
    {
        $article->likes++;
        $article->save();

        return $article->likes;
    }

    /**
     * Increment count_views
     *
     * @param Article $article
     * @return int
     */
    public function addCountViews(Article $article): int
    {
        $article->count_views++;
        $article->save();

        return $article->count_views;
    }
}
