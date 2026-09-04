<?php

namespace Krak\SymfonyMessengerRedis\Tests\Feature;

trait RedisSteps
{
    /** @var \Redis */
    private $redis;

    private function given_a_redis_client_is_configured_with_a_fresh_redis_db(): void {
        $dsn = parse_url((string) getenv('REDIS_DSN'));
        if ($dsn === false) {
            throw new \RuntimeException('The REDIS_DSN environment variable is invalid.');
        }

        $this->redis = new \Redis();
        $this->redis->connect($dsn['host'] ?? '127.0.0.1', $dsn['port'] ?? 6379);
        if (isset($dsn['pass'])) {
            $this->redis->auth($dsn['pass']);
        }
        $this->redis->flushAll();
    }
}
