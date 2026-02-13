<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\ValueObjects;

use InvalidArgumentException;
use Stringable;

final class Email implements Stringable
{
    private function __construct(
        private string $value
    ) {}

    public static function fromString(string $email): self
    {
        $email = strtolower(trim($email));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format.');
        }

        return new self($email);
    }

    public function equals(self $other): bool
    {
        return $this->value === (string) $other;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
