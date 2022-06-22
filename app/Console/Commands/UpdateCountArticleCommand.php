<?php

namespace App\Console\Commands;

use App\Helpers\CacheHelper;
use App\Models\Article;
use Illuminate\Console\Command;

class UpdateCountArticleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'article:update-counts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command update counts views and likes of articles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cacheKey = config('article.cache_key_counts');
        $articles = CacheHelper::getCacheData($cacheKey) ?? [];

        foreach ($articles as $articleSlug => $counts) {
            Article::firstWhere(['slug' => $articleSlug])->update([
                'likes' => $counts['likes'],
                'count_views' => $counts['count_views'],
            ]);
        }

        CacheHelper::forgetCacheData($cacheKey) ?? [];

        $this->info('Updated ' . count($articles) . ' articles');

        return 0;
    }
}
