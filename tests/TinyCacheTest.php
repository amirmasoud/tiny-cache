<?php

use Amirmasoud\TinyCache\TinyCache;

/** @var \Amirmasoud\TinyCache\Tests\TestCase $this */
it('will return false when checking existence of not existing string key', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['has'])->getMock();
    $this->assertFalse($cache->has('foobar'));
});

it('will return true when checking existence of existing string key', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['has', 'put'])->getMock();
    $this->assertTrue($cache->put('foo', 'bar'));
    $this->assertTrue($cache->has('foo'));
});

it('will return null when getting not existing string key', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['get'])->getMock();
    $this->assertNull($cache->get('foo'));
});

it('will put and get string key', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['put', 'get'])->getMock();
    $this->assertTrue($cache->put('foo', 'bar'));
    $this->assertEquals($cache->get('foo'), 'bar');
});

it('will increment exiting string key', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['put', 'increment', 'get'])->getMock();
    $this->assertTrue($cache->put('foo', 1));
    $this->assertTrue($cache->increment('foo'), true);
    $this->assertEquals($cache->get('foo'), 2);
});

it('will return false on incrementing not exiting string key', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['increment'])->getMock();
    $this->assertFalse($cache->increment('foo'));
});

it('will decrement exiting string key', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['put', 'decrement', 'get'])->getMock();
    $this->assertTrue($cache->put('foo', 1));
    $this->assertTrue($cache->decrement('foo'), true);
    $this->assertEquals($cache->get('foo'), 0);
});

it('will return false on decrementing not exiting string key', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['decrement'])->getMock();
    $this->assertFalse($cache->decrement('foo'));
});

it('will save forever and get string key', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['forever', 'get'])->getMock();
    $this->assertTrue($cache->forever('foo', 'bar'));
    $this->assertEquals($cache->get('foo'), 'bar');
});

it('will forget string key', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['put', 'forget', 'get', 'has'])->getMock();
    $this->assertTrue($cache->put('foo', 'bar'));
    $this->assertEquals($cache->get('foo'), 'bar');
    $this->assertTrue($cache->forget('foo'));
    $this->assertFalse($cache->has('foo'));
});

it('will flush everything', function () {
    $cache = $this->getMockBuilder(TinyCache::class)->onlyMethods(['put', 'flush', 'has'])->getMock();
    $this->assertTrue($cache->put('foo', 'bar'));
    $this->assertTrue($cache->flush());
    $this->assertFalse($cache->has('foo'));
});
