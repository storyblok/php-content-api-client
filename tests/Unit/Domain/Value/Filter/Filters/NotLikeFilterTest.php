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
use Storyblok\Api\Domain\Value\Filter\Filters\NotLikeFilter;
use Storyblok\Api\Domain\Value\Filter\Operation;
use Storyblok\Api\Tests\Unit\Domain\Value\Filter\FilterTestCase;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class NotLikeFilterTest extends FilterTestCase
{
    public static function operation(): Operation
    {
        return Operation::NotLike;
    }

    public static function filterClass(): string
    {
        return NotLikeFilter::class;
    }

    #[Test]
    public function toArray(): void
    {
        $faker = self::faker();
        $filter = new NotLikeFilter($field = $faker->word(), $value = $faker->word());

        self::assertSame([
            $field => [
                Operation::NotLike->value => $value,
            ],
        ], $filter->toArray());
    }

    #[Test]
    public function field(): void
    {
        $faker = self::faker();
        $filter = new NotLikeFilter($field = $faker->word(), $faker->word());

        self::assertSame($field, $filter->field());
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function fieldInvalid(string $field): void
    {
        self::expectException(\InvalidArgumentException::class);

        new NotLikeFilter($field, self::faker()->word());
    }
}
