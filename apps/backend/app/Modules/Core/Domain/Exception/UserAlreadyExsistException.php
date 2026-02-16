<?php

namespace App\Modules\User\Domain\Exceptions;

use DomainException;
use App\Modules\User\Domain\ValueObjects\Username;
use App\Modules\User\Domain\ValueObjects\Email;

final class UserAlreadyExistsException extends DomainException
{
    private string $field;

    private function __construct(string $field, string $value)
    {
        $this->field = $field;

        parent::__construct(sprintf(
            '%s "%s" is already taken.',
            ucfirst($field),
            $value
        ));
    }

    public static function username(Username $username): self
    {
        return new self('username', $username->value());
    }

    public static function email(Email $email): self
    {
        return new self('email', $email->value());
    }

    public function field(): string
    {
        return $this->field;
    }
}
