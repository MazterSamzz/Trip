<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\ValueObjects;

use Stringable;
use Symfony\Component\Uid\UuidV7;

final class UserId implements Stringable
{
    private function __construct(
        private string $value
    ) {}

    public static function generate(): self
    {
        return new self((string) UuidV7::generate());
    }

    public static function fromString(string $id): self
    {
        // optional: validasi UUIDv7
        return new self($id);
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
