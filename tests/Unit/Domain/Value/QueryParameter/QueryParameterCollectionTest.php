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

namespace Storyblok\Api\Tests\Unit\Domain\Value\QueryParameter;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\QueryParameter\Operator;
use Storyblok\Api\Domain\Value\QueryParameter\PublishedAtQueryParameter;
use Storyblok\Api\Domain\Value\QueryParameter\QueryParameter;
use Storyblok\Api\Domain\Value\QueryParameter\QueryParameterCollection;
use Storyblok\Api\Domain\Value\QueryParameter\UpdatedAtQueryParameter;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Frank Stelzer <dev@frankstelzer.de>
 * @author Silas Joisten <silasjoisten@proton.me>
 */
class QueryParameterCollectionTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function constructWithString(): void
    {
        $faker = self::faker();

        $queryParameter1 = new PublishedAtQueryParameter($faker->dateTime(), Operator::GreaterThan);
        $queryParameter2 = new UpdatedAtQueryParameter($faker->dateTime(), Operator::GreaterThan);
        $collection = new QueryParameterCollection([$queryParameter1, $queryParameter2]);

        self::assertCount(2, $collection);
        self::assertContainsOnlyInstancesOf(QueryParameter::class, $collection);
    }

    #[Test]
    public function add(): void
    {
        $faker = self::faker();

        $collection = new QueryParameterCollection();
        self::assertEmpty($collection);

        $collection->add(new PublishedAtQueryParameter($faker->dateTime(), Operator::GreaterThan));
        self::assertCount(1, $collection);
    }

    #[Test]
    public function remove(): void
    {
        $faker = self::faker();

        $queryParameter = new PublishedAtQueryParameter($faker->dateTime(), Operator::GreaterThan);

        $collection = new QueryParameterCollection([$queryParameter]);
        self::assertCount(1, $collection);

        $collection->remove($queryParameter);
        self::assertEmpty($collection);
    }

    #[Test]
    public function hasReturnsTrue(): void
    {
        $faker = self::faker();

        $queryParameter = new PublishedAtQueryParameter($faker->dateTime(), Operator::GreaterThan);

        $collection = new QueryParameterCollection([$queryParameter]);

        self::assertTrue($collection->has($queryParameter));
    }

    #[Test]
    public function hasReturnsFalse(): void
    {
        $faker = self::faker();

        $queryParameter = new PublishedAtQueryParameter($faker->dateTime(), Operator::GreaterThan);
        $otherQueryParameter = new UpdatedAtQueryParameter($faker->dateTime(), Operator::GreaterThan);

        $collection = new QueryParameterCollection([$queryParameter]);

        self::assertFalse($collection->has($otherQueryParameter));
    }

    #[Test]
    public function isCountable(): void
    {
        $faker = self::faker();

        $queryParameter = new PublishedAtQueryParameter($faker->dateTime(), Operator::GreaterThan);

        $collection = new QueryParameterCollection([$queryParameter]);

        self::assertCount(1, $collection);
    }

    #[Test]
    public function toArrayMethod(): void
    {
        $faker = self::faker();

        $date1 = $faker->dateTime();
        $expectedDate1 = $date1->format('Y-m-d H:i');

        $date2 = $faker->dateTime();
        $expectedDate2 = $date2->format('Y-m-d H:i');

        $expectedArray = [
            PublishedAtQueryParameter::PUBLISHED_AT_GT => $expectedDate1,
            UpdatedAtQueryParameter::UPDATED_AT_GT => $expectedDate2,
        ];

        $queryParameters = [
            new PublishedAtQueryParameter($date1, Operator::GreaterThan),
            new UpdatedAtQueryParameter($date2, Operator::GreaterThan),
        ];

        $collection = new QueryParameterCollection($queryParameters);

        self::assertSame($expectedArray, $collection->toArray());
    }

    #[Test]
    public function getIterator(): void
    {
        $faker = self::faker();

        $parameters = [
            new PublishedAtQueryParameter($faker->dateTime(), Operator::GreaterThan),
            new UpdatedAtQueryParameter($faker->dateTime(), Operator::GreaterThan),
        ];

        self::assertInstanceOf(\ArrayIterator::class, (new QueryParameterCollection($parameters))->getIterator());
    }
}
