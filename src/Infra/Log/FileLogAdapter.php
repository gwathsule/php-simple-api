<?php

namespace Src\Infra\Log;

use Src\Domain\Contracts\Logger;

use Throwable;

class FileLogAdapter implements Logger
{
    private const MAIN_PATH = '/var/www/storage/log/';
    private const PATH_EXCEPTIONS = self::MAIN_PATH . 'exceptions.log';
    private const PATH_INFO = self::MAIN_PATH . 'info.log';


    public function logException(Throwable $exception): void
    {
        if(getenv('APP_ENV') === 'testing') {
            return;
        }

        $log = [
            'time' => date('Y-m-d H:m:s'),
            'message' => $exception->getMessage(),
            'trace' => $exception->getTrace()
        ];

        $this->saveOnFile(self::PATH_EXCEPTIONS, json_encode($log));
    }

    public function logInfo(string $title, array $data): void
    {
        if(getenv('APP_ENV') === 'testing') {
            return;
        }

        $log = [
            'time' => date('Y-m-d H:m:s'),
            'title' => $title,
            'data' => $data,
        ];

        $this->saveOnFile(self::PATH_INFO, json_encode($log));
    }

    private function saveOnFile($path, string $json)
    {
        file_put_contents($path , $json.PHP_EOL, FILE_APPEND);
    }
}