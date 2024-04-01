<?php

namespace Core;
use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{

    #[\Override] public function emergency(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement emergency() method.
    }

    #[\Override] public function alert(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement alert() method.
    }

    #[\Override] public function critical(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement critical() method.
    }

    #[\Override] public function error(\Stringable|string $message, array $context = []): void
    {
        $date = date('Y/m/d H:i:s');
        $context = implode("\n", $context);
        $message = $message . "\n" . 'date: ' . $date . "\n" . $context;
        file_put_contents(dirname(__DIR__) . '/Storage/Logs/errors.txt', $message . "\n\n", FILE_APPEND);
    }

    #[\Override] public function warning(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement warning() method.
    }

    #[\Override] public function notice(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement notice() method.
    }

    #[\Override] public function info(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement info() method.
    }

    #[\Override] public function debug(\Stringable|string $message, array $context = []): void
    {
        // TODO: Implement debug() method.
    }

    #[\Override] public function log($level, \Stringable|string $message, array $context = []): void
    {
        // TODO: Implement log() method.
    }
}