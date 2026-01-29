<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait OptimizedSearch
{
    /**
     * Get search results with caching
     */
    public function getSearchResults($modelClass, $search, $perPage)
    {
        // If no search, return all without cache
        if (empty($search)) {
            return $modelClass::query()
                ->with($this->getRelationsToLoad())
                ->paginate($perPage);
        }

        // Create cache key based on search term and page
        $cacheKey = $this->getSearchCacheKey($modelClass, $search, $perPage);

        // Cache results for 5 minutes
        return Cache::remember($cacheKey, 300, function () use ($modelClass, $search, $perPage) {
            return $modelClass::query()
                ->search($search)
                ->with($this->getRelationsToLoad())
                ->paginate($perPage);
        });
    }

    /**
     * Get relations to load based on selected columns
     */
    protected function getRelationsToLoad()
    {
        if (!isset($this->relations) || !isset($this->columns)) {
            return [];
        }

        return array_intersect($this->relations, $this->columns);
    }

    /**
     * Generate cache key for search
     */
    protected function getSearchCacheKey($modelClass, $search, $perPage)
    {
        $page = request()->get('page', 1);
        $userId = getActiveUserId() ?? 'guest';

        return sprintf(
            'search:%s:%s:%s:%d:%d',
            class_basename($modelClass),
            md5($search),
            $userId,
            $page,
            $perPage
        );
    }

    /**
     * Clear search cache for model
     */
    public function clearSearchCache($modelClass)
    {
        $pattern = sprintf('search:%s:*', class_basename($modelClass));

        // Note: This requires Redis or a cache driver that supports pattern deletion
        // For file/database cache, you might need a different approach
        if (config('cache.default') === 'redis') {
            $keys = Cache::getRedis()->keys($pattern);
            if (!empty($keys)) {
                Cache::getRedis()->del($keys);
            }
        }
    }
}
