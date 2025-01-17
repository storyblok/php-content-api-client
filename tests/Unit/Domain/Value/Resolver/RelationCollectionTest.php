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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Resolver;

use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Resolver\Relation;
use Storyblok\Api\Domain\Value\Resolver\RelationCollection;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class RelationCollectionTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function add(): void
    {
        $faker = self::faker();

        $collection = new RelationCollection();
        self::assertEmpty($collection);

        $collection->add(new Relation($faker->relation()));
        self::assertCount(1, $collection);
    }

    /**
     * @test
     */
    public function remove(): void
    {
        $faker = self::faker();

        $relation = new Relation($faker->relation());

        $collection = new RelationCollection([$relation]);
        self::assertCount(1, $collection);

        $collection->remove($relation);
        self::assertEmpty($collection);
    }

    /**
     * @test
     */
    public function hasReturnsTrue(): void
    {
        $faker = self::faker();

        $relation = new Relation($faker->relation());

        $collection = new RelationCollection([$relation, new Relation($faker->relation())]);

        self::assertTrue($collection->has($relation));
    }

    /**
     * @test
     */
    public function hasReturnsFalse(): void
    {
        $faker = self::faker();

        $collection = new RelationCollection([new Relation($faker->relation())]);

        self::assertFalse($collection->has(new Relation($faker->relation())));
    }

    /**
     * @test
     */
    public function isCountable(): void
    {
        $faker = self::faker();

        $relation = new Relation($faker->relation());

        $collection = new RelationCollection([$relation]);

        self::assertSame(1, $collection->count());
    }

    /**
     * @test
     */
    public function toStringMethod(): void
    {
        $faker = self::faker();

        $relations = [
            new Relation($relation1 = $faker->relation()),
            new Relation($relation2 = $faker->relation()),
            new Relation($relation3 = $faker->relation()),
        ];

        $collection = new RelationCollection($relations);

        self::assertSame(implode(',', [$relation1, $relation2, $relation3]), $collection->toString());
    }

    /**
     * @test
     */
    public function getIterator(): void
    {
        $faker = self::faker();

        $relations = [
            new Relation($faker->relation()),
            new Relation($faker->relation()),
        ];

        self::assertInstanceOf(\ArrayIterator::class, (new RelationCollection($relations))->getIterator());
    }
}
