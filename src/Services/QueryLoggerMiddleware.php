<?php

declare(strict_types=1);

namespace App\Services;

use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\Middleware;
use Psr\Log\LoggerInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsMiddleware;

#[AsMiddleware]
final readonly class QueryLoggerMiddleware implements Middleware
{
    public function __construct(private LoggerInterface $logger, private QueryKeeper $queryKeeper) {}

    public function wrap(Driver $driver): Driver
    {
        return new QueryLoggerDriverMiddleware($driver, $this->logger, $this->queryKeeper);
    }
}
