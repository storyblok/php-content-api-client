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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Filter\Filters;

use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use Storyblok\Api\Domain\Value\Filter\Filters\LessThanDateFilter;
use Storyblok\Api\Domain\Value\Filter\Operation;
use Storyblok\Api\Tests\Unit\Domain\Value\Filter\FilterTestCase;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class LessThanDateFilterTest extends FilterTestCase
{
    public static function operation(): Operation
    {
        return Operation::LessThanDate;
    }

    public static function filterClass(): string
    {
        return LessThanDateFilter::class;
    }

    #[Test]
    public function toArray(): void
    {
        $faker = self::faker();
        $filter = new LessThanDateFilter($field = $faker->word(), $value = $faker->dateTime());

        self::assertSame([
            $field => [
                Operation::LessThanDate->value => $value->format('Y-m-d H:i'),
            ],
        ], $filter->toArray());
    }

    #[Test]
    public function field(): void
    {
        $faker = self::faker();
        $filter = new LessThanDateFilter($field = $faker->word(), $faker->dateTime());

        self::assertSame($field, $filter->field());
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function fieldInvalid(string $field): void
    {
        self::expectException(\InvalidArgumentException::class);

        new LessThanDateFilter($field, self::faker()->dateTime());
    }
}
