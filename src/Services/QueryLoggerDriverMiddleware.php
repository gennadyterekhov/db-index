<?php

declare(strict_types=1);

namespace App\Services;

use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\Middleware\AbstractDriverMiddleware;
use Psr\Log\LoggerInterface;

final class QueryLoggerDriverMiddleware extends AbstractDriverMiddleware
{
    public function __construct(
        Driver $driver,
        private readonly LoggerInterface $logger,
        private readonly QueryKeeper $queryKeeper,
    )
    {
        parent::__construct($driver);
    }

    public function connect(array $params): Connection
    {
        $connection = parent::connect($params);

        return new QueryLoggerConnection($connection, $this->logger, $this->queryKeeper);
    }
}
