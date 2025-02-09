<?php
namespace App\Service;
/**
 * Classe qui trace les actions faites (si y'a une erreur lié a la db regarder log.txt ca peut aider)
 * Pour rappel mail UNIQUE !
 */
class LoggerService {
    private string $logFile;

    public function __construct(string $logFile = __DIR__ . '/../../log.txt') {
        $this->logFile = $logFile;
    }

    public function log(string $action, string $message): void {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] [$action] $message" . PHP_EOL;
        file_put_contents($this->logFile, $logEntry, FILE_APPEND);
    }
}
