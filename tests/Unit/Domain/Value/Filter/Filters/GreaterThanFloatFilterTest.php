<?php

declare(strict_types=1);

/**
 * This file is part of Storyblok-Api.
 *
 * (c) SensioLabs Deutschland <info@sensiolabs.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Storyblok\Api\Tests\Unit\Domain\Value\Filter\Filters;

use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use Storyblok\Api\Domain\Value\Filter\Filters\GreaterThanFloatFilter;
use Storyblok\Api\Domain\Value\Filter\Operation;
use Storyblok\Api\Tests\Unit\Domain\Value\Filter\FilterTestCase;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class GreaterThanFloatFilterTest extends FilterTestCase
{
    public static function operation(): Operation
    {
        return Operation::GreaterThanFloat;
    }

    public static function filterClass(): string
    {
        return GreaterThanFloatFilter::class;
    }

    #[Test]
    public function toArray(): void
    {
        $faker = self::faker();
        $filter = new GreaterThanFloatFilter($field = $faker->word(), $value = $faker->randomFloat());

        self::assertSame([
            $field => [
                Operation::GreaterThanFloat->value => (string) $value,
            ],
        ], $filter->toArray());
    }

    #[Test]
    public function field(): void
    {
        $faker = self::faker();
        $filter = new GreaterThanFloatFilter($field = $faker->word(), $faker->randomFloat());

        self::assertSame($field, $filter->field());
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function fieldInvalid(string $field): void
    {
        self::expectException(\InvalidArgumentException::class);

        new GreaterThanFloatFilter($field, self::faker()->randomFloat());
    }
}
