<?php

declare(strict_types=1);

/**
 * This file is part of storyblok/php-content-api-client.
 *
 * (c) Storyblok GmbH <info@storyblok.com>
 * in cooperation with SensioLabs Deutschland <info@sensiolabs.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Storyblok\Api\Tests\Unit\Domain\Value;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Id;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class IdTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function value(): void
    {
        $value = self::faker()->numberBetween(1);

        self::assertSame($value, (new Id($value))->value);
    }

    #[DataProvider('provideInvalidValues')]
    #[Test]
    public function valueInvalid(int $value): void
    {
        self::expectException(\InvalidArgumentException::class);

        new Id($value);
    }

    /**
     * @return iterable<array{0: int}>
     */
    public static function provideInvalidValues(): iterable
    {
        yield 'zero' => [0];
        yield 'negative_number' => [-1];
    }

    #[Test]
    public function equalsReturnsTrue(): void
    {
        $value = self::faker()->numberBetween(1);

        self::assertTrue((new Id($value))->equals(new Id($value)));
    }

    #[Test]
    public function equalsReturnsFalse(): void
    {
        self::assertFalse((new Id(1))->equals(new Id(2)));
    }
}
