<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\ValueObjects;

use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Stringable;

final class Password implements Stringable
{
    private function __construct(private string $value) {}

    /**
     * New password from plain text, will be hashed internally
     */
    public static function make(string $plain): self
    {
        if (strlen($plain) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters.');
        }

        return new self(Hash::make($plain));
    }

    /**
     * Existing password hash (e.g. from database), will be used as-is
     */
    public static function fromhash(string $value): self
    {
        return new self($value);
    }

    public function verify(string $plain): bool
    {
        return Hash::check($plain, $this->value);
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
