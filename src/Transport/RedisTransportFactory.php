<?php

namespace Krak\SymfonyMessengerRedis\Transport;

use Symfony\Component\Messenger\Transport\{
    TransportInterface,
    TransportFactoryInterface,
    Serialization\SerializerInterface
};
use Symfony\Component\Messenger\Bridge\Redis\Transport\RedisTransportFactory as SymfonyRedisTransportFactory;

final class RedisTransportFactory implements TransportFactoryInterface
{
    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface {
        if (!boolval($options['use_krak_redis'] ?? true)) {
            unset($options['use_krak_redis']);

            if (!class_exists(SymfonyRedisTransportFactory::class)) {
                throw new \LogicException('Install symfony/redis-messenger to use Symfony\'s native Redis transport.');
            }

            return (new SymfonyRedisTransportFactory())->createTransport($dsn, $options, $serializer);
        }

        return RedisTransport::fromDsn($serializer, $dsn, $options);
    }

    /**
     * Symfony's redis factory also matches on the redis:// prefix, so to support using
     * both redis adapters at the same time, the `use_krak_redis` option delegates to
     * Symfony's native Redis transport.
     */
    public function supports(string $dsn, array $options): bool {
        return strpos($dsn, 'redis://') === 0 || strpos($dsn, 'rediss://') === 0;
    }
}
