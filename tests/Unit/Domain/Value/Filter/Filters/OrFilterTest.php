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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Storyblok\Api\Domain\Value\Filter\Filters\Filter;
use Storyblok\Api\Domain\Value\Filter\Filters\InFilter;
use Storyblok\Api\Domain\Value\Filter\Filters\LikeFilter;
use Storyblok\Api\Domain\Value\Filter\Filters\OrFilter;
use Storyblok\Api\Domain\Value\Filter\Operation;
use Storyblok\Api\Tests\Unit\Domain\Value\Filter\FilterTestCase;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class OrFilterTest extends FilterTestCase
{
    public static function operation(): Operation
    {
        return Operation::Or;
    }

    public static function filterClass(): string
    {
        return OrFilter::class;
    }

    #[Test]
    public function toArray(): void
    {
        $filter = new OrFilter(new InFilter('title', 'Fancy title'), new LikeFilter('title', '*test'));

        self::assertSame([
            Operation::Or->value => [
                [
                    'title' => [
                        Operation::In->value => 'Fancy title',
                    ],
                ],
                [
                    'title' => [
                        Operation::Like->value => '*test',
                    ],
                ],
            ],
        ], $filter->toArray());
    }

    #[Test]
    public function field(): void
    {
        $filter = new OrFilter(new InFilter('title', 'Fancy title'), new LikeFilter('title', '*test'));

        self::assertSame('title|title', $filter->field());
    }

    /**
     * @param list<Filter> $filters
     */
    #[DataProvider('invalidValues')]
    #[Test]
    public function invalid(array $filters): void
    {
        self::expectException(\InvalidArgumentException::class);

        new OrFilter(...$filters);
    }

    /**
     * @return iterable<string, array<mixed>>
     */
    public static function invalidValues(): iterable
    {
        $faker = self::faker();

        yield 'one filter passed' => [[new InFilter($faker->word(), $faker->word())]];
    }

    #[Test]
    public function filtersCanBeTheSameForField(): void
    {
        $filter = new OrFilter(
            new LikeFilter('title', 'Fancy title'),
            new LikeFilter('title', '*test'),
        );

        self::assertSame([
            Operation::Or->value => [
                [
                    'title' => [
                        Operation::Like->value => 'Fancy title',
                    ],
                ],
                [
                    'title' => [
                        Operation::Like->value => '*test',
                    ],
                ],
            ],
        ], $filter->toArray());
    }
}
