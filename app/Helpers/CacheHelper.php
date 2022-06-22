<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

/**
 * Class CacheHelper
 * @package App\Helpers
 */
class CacheHelper
{
    /**
     * get cache data
     *
     * @param string $store
     * @param string $cacheKey
     * @return mixed|null
     */
    public static function getCacheData(string $cacheKey, string $store = 'file')
    {
        if (Cache::store($store)->has($cacheKey)) {
            return Cache::store($store)->get($cacheKey);
        }

        return null;
    }

    /**
     * set cache data
     *
     * @param string $store
     * @param string $cacheKey
     * @param $data
     */
    public static function setCacheData(string $cacheKey, $data, string $store = 'file')
    {
        Cache::store($store)->put($cacheKey, $data);
    }

    /**
     * Delete cache by key
     */
    public static function forgetCacheData(string $cacheKey, string $store = 'file')
    {
        Cache::store($store)->delete($cacheKey);
    }
}
