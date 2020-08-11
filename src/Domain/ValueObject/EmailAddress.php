<?php

declare(strict_types=1);

namespace Domain\ValueObject;

use Domain\Exception\ValueObject\EmailAddressIsNotValid;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

/*
 * @psalm-immutable
 */
final class EmailAddress
{
    private string $emailAddress;

    private function __construct(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @throws EmailAddressIsNotValid
     */
    public static function create(string $emailAddress) : self
    {
        self::validate($emailAddress);

        return new self(
            $emailAddress
        );
    }

    public function asString() : string
    {
        return $this->emailAddress;
    }

    public function equalsTo(EmailAddress $anotherEmailAddress) : bool
    {
        return $this->emailAddress === $anotherEmailAddress->emailAddress;
    }

    /**
     * @throws EmailAddressIsNotValid
     */
    private static function validate(string $emailAddress) : void
    {
        try {
            Assert::email($emailAddress);
        } catch (InvalidArgumentException $e) {
            throw EmailAddressIsNotValid::withFormat($emailAddress);
        }
    }
}
