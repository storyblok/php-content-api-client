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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Filter;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Filter\FilterCollection;
use Storyblok\Api\Domain\Value\Filter\Filters\GreaterThanIntFilter;
use Storyblok\Api\Domain\Value\Filter\Filters\IsFilter;
use Storyblok\Api\Domain\Value\Filter\Filters\LikeFilter;
use Storyblok\Api\Domain\Value\Filter\Operation;
use Storyblok\Api\Exception\FilterCanNotBeUsedMultipleTimes;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class FilterCollectionTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function add(): void
    {
        $faker = self::faker();

        $collection = new FilterCollection();
        self::assertEmpty($collection);

        $collection->add(new IsFilter($faker->word(), IsFilter::EMPTY));
        self::assertCount(1, $collection);
    }

    #[Test]
    public function remove(): void
    {
        $faker = self::faker();

        $filter = new IsFilter($faker->word(), IsFilter::EMPTY);

        $collection = new FilterCollection([$filter]);
        self::assertCount(1, $collection);

        $collection->remove($filter);
        self::assertEmpty($collection);
    }

    #[Test]
    public function hasReturnsTrue(): void
    {
        $faker = self::faker();

        $filter = new IsFilter($faker->word(), IsFilter::EMPTY);

        $collection = new FilterCollection([$filter, new IsFilter($faker->word(), IsFilter::NOT_EMPTY_ARRAY)]);

        self::assertTrue($collection->has($filter));
    }

    #[Test]
    public function hasReturnsFalse(): void
    {
        $faker = self::faker();

        $collection = new FilterCollection([new IsFilter($faker->word(), IsFilter::NOT_EMPTY_ARRAY)]);

        self::assertFalse($collection->has(new IsFilter($faker->word(), IsFilter::EMPTY)));
    }

    #[Test]
    public function isCountable(): void
    {
        $faker = self::faker();

        $filter = new IsFilter($faker->word(), IsFilter::EMPTY);

        $collection = new FilterCollection([$filter]);

        self::assertCount(1, $collection);
    }

    #[Test]
    public function toArray(): void
    {
        $filters = [
            new IsFilter('field', IsFilter::EMPTY),
            new IsFilter('title', IsFilter::NOT_EMPTY_ARRAY),
            new IsFilter('description', IsFilter::FALSE),
        ];

        $collection = new FilterCollection($filters);

        self::assertSame([
            'field' => [
                Operation::Is->value => IsFilter::EMPTY,
            ],
            'title' => [
                Operation::Is->value => IsFilter::NOT_EMPTY_ARRAY,
            ],
            'description' => [
                Operation::Is->value => IsFilter::FALSE,
            ],
        ], $collection->toArray());
    }

    #[Test]
    public function toArrayFiltersGetCombined(): void
    {
        $filters = [
            new IsFilter('title', IsFilter::EMPTY),
            new LikeFilter('title', '*fooo'),
        ];

        $collection = new FilterCollection($filters);

        self::assertSame([
            'title' => [
                Operation::Is->value => IsFilter::EMPTY,
                Operation::Like->value => '*fooo',
            ],
        ], $collection->toArray());
    }

    #[Test]
    public function throwsExceptionIfAlreadyInCollectionAndFilterCanBeUsedOnlyOnceForAField(): void
    {
        $faker = self::faker();

        $filters = [
            new GreaterThanIntFilter('stock', $faker->unique()->randomNumber()),
            new GreaterThanIntFilter('stock', $faker->unique()->randomNumber()),
        ];

        self::expectException(FilterCanNotBeUsedMultipleTimes::class);

        new FilterCollection($filters);
    }

    #[Test]
    public function getIterator(): void
    {
        $filters = [
            new IsFilter('title', IsFilter::EMPTY),
            new LikeFilter('title', '*fooo'),
        ];

        self::assertInstanceOf(\ArrayIterator::class, (new FilterCollection($filters))->getIterator());
    }
}
