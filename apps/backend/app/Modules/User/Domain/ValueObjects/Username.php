<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\ValueObjects;

use Stringable;

final class Username implements Stringable
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $value)) {
            throw new \InvalidArgumentException('Invalid username format. It must be 3-20 characters long and can only contain letters, numbers, and underscores.');
        }

        return new self(strtolower($value));
    }

    public function equals(self $other): bool
    {
        return $this->value === (string) $other;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
