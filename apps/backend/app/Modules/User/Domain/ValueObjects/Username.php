<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\ValueObjects;

final class Username
{
    private string $value;

    public function __construct(string $value)
    {
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $value)) {
            throw new \InvalidArgumentException('Invalid username format. It must be 3-20 characters long and can only contain letters, numbers, and underscores.');
        }

        $this->value = strtolower($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
