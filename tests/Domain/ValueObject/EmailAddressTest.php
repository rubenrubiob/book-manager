<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use Domain\Exception\ValueObject\EmailAddressIsNotValid;
use Domain\ValueObject\EmailAddress;
use PHPUnit\Framework\TestCase;

class EmailAddressTest extends TestCase
{
    /**
     * @test
     */
    public function create(): void
    {
        $email = 'valid@email.address';

        $emailAddress = EmailAddress::create($email);

        $this->assertSame(
            $email,
            $emailAddress->asString()
        );
    }

    /**
     * @test
     * @dataProvider provideForEqualsTo
     */
    public function equals_to(string $firstEmailAddress, string $secondEmailAddress, bool $expected): void
    {
        $this->assertSame(
            $expected,
            EmailAddress::create($firstEmailAddress)->equalsTo(
                EmailAddress::create($secondEmailAddress)
            )
        );
    }

    /**
     * @test
     */
    public function create_with_invalid_email_address_throws_exception(): void
    {
        $this->expectException(EmailAddressIsNotValid::class);

        EmailAddress::create('this_is_not_a_valid_email_address@domain');
    }

    /**
     * @test
     */
    public function create_with_empty_email_address_throws_exception(): void
    {
        $this->expectException(EmailAddressIsNotValid::class);

        EmailAddress::create('  ');
    }

    /**
     * @return array[]
     */
    public function provideForEqualsTo(): array
    {
        return [
            'equal email addresses' => [
                'foo@bar.com',
                'foo@bar.com',
                true,
            ],
            'different email addresses' => [
                'foo@bar.com',
                'bar@foo.com',
                false,
            ],
        ];
    }
}
