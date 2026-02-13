<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\ValueObjects;

use InvalidArgumentException;
use Stringable;

final class ProviderName implements Stringable
{
    public const PASSWORD = 'password';
    public const GOOGLE = 'google';
    public const GITHUB = 'github';

    private const PROVIDER = [
        self::PASSWORD,
        self::GOOGLE,
        self::GITHUB,
    ];

    private function __construct(
        private string $value
    ) {}

    public static function fromString(string $value): self
    {
        $value = strtolower(trim($value));

        if (!in_array($value, self::PROVIDER, true)) {
            throw new InvalidArgumentException("Invalid provider: {$value}");
        }

        return new self($value);
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
