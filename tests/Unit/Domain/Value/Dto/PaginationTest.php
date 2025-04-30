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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Dto;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class PaginationTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function defaults(): void
    {
        self::assertSame(1, (new Pagination())->page);
        self::assertSame(25, (new Pagination())->perPage);
    }

    #[Test]
    public function page(): void
    {
        $value = self::faker()->numberBetween(1);

        self::assertSame($value, (new Pagination($value))->page);
    }

    #[Test]
    public function pageMustBePositiveInt(): void
    {
        $value = self::faker()->numberBetween(-100, 0);

        self::expectException(\InvalidArgumentException::class);

        new Pagination($value);
    }

    #[Test]
    public function pageMustNotBeZero(): void
    {
        self::expectException(\InvalidArgumentException::class);

        new Pagination(0);
    }

    #[Test]
    public function perPage(): void
    {
        $value = self::faker()->numberBetween(1);

        self::assertSame($value, (new Pagination(perPage: $value))->perPage);
    }

    #[Test]
    public function perPageMustBePositiveInt(): void
    {
        $value = self::faker()->numberBetween(-100, 0);

        self::expectException(\InvalidArgumentException::class);

        new Pagination(perPage: $value);
    }

    #[Test]
    public function perPageMustNotBeZero(): void
    {
        self::expectException(\InvalidArgumentException::class);

        new Pagination(perPage: 0);
    }
}
