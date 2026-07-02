<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\PsrLogMessageProcessor;

class CreateMonthlyDailyLogger
{
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('monthly-daily');

        $monthDir = date('Y-m');
        $logPath = storage_path("logs/{$monthDir}/laravel.log");

        $handler = new RotatingFileHandler(
            $logPath,
            $config['days'] ?? 14,
            $config['level'] ?? Logger::DEBUG,
            true,
            0644
        );

        $logger->pushHandler($handler);
        $logger->pushProcessor(new PsrLogMessageProcessor());

        return $logger;
    }
}