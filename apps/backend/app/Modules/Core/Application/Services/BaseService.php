<?php

declare(strict_types=1);

namespace App\Modules\Core\Application\Services;

class BaseService
{
    public function log(string $message): void
    {
        // contoh log sederhana
        logger($message);
    }
}
