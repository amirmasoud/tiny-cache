<?php

namespace Amirmasoud\TinyCache;

use Illuminate\Contracts\Cache\Store;

class TinyCache implements Store
{
    /**
     * The array of stored values.
     *
     * @var array
     */
    protected static $storage = [];

    /**
     * A string that should be prepended to keys.
     *
     * @var string
     */
    protected $prefix;

    /**
     * @param  string|array  $key
     */
    public function has($key): bool
    {
        return is_array($key)
            ? array_walk($key, fn ($val) => $this->has($val))
            : array_key_exists($key, static::$storage);
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string|array  $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->has($key) ? static::$storage[$key] : null;
    }

    /**
     * Retrieve multiple items from the cache by key.
     * Items not found in the cache will have a null value.
     *
     * @return array
     */
    public function many(array $keys)
    {
        return array_map(fn ($key) => $this->get($key), $keys);
    }

    /**
     * Store an item in the cache for a given number of seconds.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  int  $seconds
     * @return bool
     */
    public function put($key, $value, $seconds = -1)
    {
        return static::$storage[$key] = $value;
    }

    /**
     * Store multiple items in the cache for a given number of seconds.
     *
     * @param  int  $seconds
     * @return bool
     */
    public function putMany(array $values, $seconds)
    {
        return (bool) array_map(fn ($value) => $this->put($value), $values);
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function increment($key, $value = 1)
    {
        if (! $this->has($key)) {
            return false;
        }

        $this->put($key, static::$storage[$key] + $value);

        return true;
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function decrement($key, $value = 1)
    {
        if (! $this->has($key)) {
            return false;
        }

        $this->put($key, static::$storage[$key] - $value);

        return true;
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return bool
     */
    public function forever($key, $value)
    {
        return $this->put($key, $value, ini_get('max_execution_time') ?: 315360000);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function forget($key)
    {
        unset(static::$storage[$key]);

        return true;
    }

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush()
    {
        static::$storage = [];

        return true;
    }

    /**
     * Get the cache key prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
}
