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

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Id;
use Storyblok\Api\Domain\Value\IdCollection;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class IdCollectionTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function constructWithInt(): void
    {
        $faker = self::faker();
        $collection = new IdCollection([$faker->numberBetween(1), $faker->numberBetween(1)]);

        self::assertCount(2, $collection);
        self::assertContainsOnlyInstancesOf(Id::class, $collection);
    }

    #[Test]
    public function add(): void
    {
        $faker = self::faker();

        $collection = new IdCollection();
        self::assertEmpty($collection);

        $collection->add(new Id($faker->numberBetween(1)));
        self::assertCount(1, $collection);
    }

    #[Test]
    public function remove(): void
    {
        $faker = self::faker();

        $field = new Id($faker->numberBetween(1));

        $collection = new IdCollection([$field]);
        self::assertCount(1, $collection);

        $collection->remove($field);
        self::assertEmpty($collection);
    }

    #[Test]
    public function hasReturnsTrue(): void
    {
        $faker = self::faker();

        $field = new Id($faker->numberBetween(1));

        $collection = new IdCollection([$field, new Id($faker->numberBetween(1))]);

        self::assertTrue($collection->has($field));
    }

    #[Test]
    public function hasReturnsFalse(): void
    {
        $faker = self::faker();

        $collection = new IdCollection([new Id($faker->numberBetween(1))]);

        self::assertFalse($collection->has(new Id($faker->numberBetween(1))));
    }

    #[Test]
    public function isCountable(): void
    {
        $faker = self::faker();

        $field = new Id($faker->numberBetween(1));

        $collection = new IdCollection([$field]);

        self::assertCount(1, $collection);
    }

    #[Test]
    public function toStringMethod(): void
    {
        $fields = [
            new Id(1),
            new Id(2),
            new Id(3),
        ];

        $collection = new IdCollection($fields);

        self::assertSame('1,2,3', $collection->toString());
    }

    #[Test]
    public function getIterator(): void
    {
        $fields = [
            new Id(1),
            new Id(2),
        ];

        self::assertInstanceOf(\ArrayIterator::class, (new IdCollection($fields))->getIterator());
    }
}
