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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use Storyblok\Api\Domain\Value\Filter\Filters\IsFilter;
use Storyblok\Api\Domain\Value\Filter\Operation;
use Storyblok\Api\Tests\Unit\Domain\Value\Filter\FilterTestCase;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class IsFilterTest extends FilterTestCase
{
    public static function operation(): Operation
    {
        return Operation::Is;
    }

    public static function filterClass(): string
    {
        return IsFilter::class;
    }

    public function toArray(): void
    {
        $faker = self::faker();
        $filter = new IsFilter($field = $faker->word(), $value = $faker->randomElement([
            IsFilter::EMPTY_ARRAY,
            IsFilter::NOT_EMPTY_ARRAY,
            IsFilter::EMPTY,
            IsFilter::NOT_EMPTY,
            IsFilter::TRUE,
            IsFilter::FALSE,
            IsFilter::NULL,
            IsFilter::NOT_NULL,
        ]));

        self::assertSame([
            $field => [
                Operation::Is->value => $value,
            ],
        ], $filter->toArray());
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function fieldInvalid(string $field): void
    {
        self::expectException(\InvalidArgumentException::class);

        new IsFilter($field, IsFilter::EMPTY);
    }

    #[DataProvider('invalidValues')]
    #[Test]
    public function valueInvalid(mixed $value): void
    {
        self::expectException(\InvalidArgumentException::class);

        new IsFilter(self::faker()->word(), $value);
    }

    /**
     * @return iterable<string, array<mixed>>
     */
    public static function invalidValues(): iterable
    {
        $faker = self::faker();

        yield 'is not one of the accepted values' => [$faker->word()];
    }
}
