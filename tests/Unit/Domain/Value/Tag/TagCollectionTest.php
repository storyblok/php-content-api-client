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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Tag;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Tag\Tag;
use Storyblok\Api\Domain\Value\Tag\TagCollection;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class TagCollectionTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function constructWithString(): void
    {
        $faker = self::faker();
        $collection = new TagCollection([$faker->word(), $faker->word()]);

        self::assertCount(2, $collection);
        self::assertContainsOnlyInstancesOf(Tag::class, $collection);
    }

    #[Test]
    public function add(): void
    {
        $faker = self::faker();

        $collection = new TagCollection();
        self::assertEmpty($collection);

        $collection->add(new Tag($faker->word()));
        self::assertCount(1, $collection);
    }

    #[Test]
    public function remove(): void
    {
        $faker = self::faker();

        $tag = new Tag($faker->word());

        $collection = new TagCollection([$tag]);
        self::assertCount(1, $collection);

        $collection->remove($tag);
        self::assertEmpty($collection);
    }

    #[Test]
    public function hasReturnsTrue(): void
    {
        $faker = self::faker();

        $tag = new Tag($faker->word());

        $collection = new TagCollection([$tag, new Tag($faker->word())]);

        self::assertTrue($collection->has($tag));
    }

    #[Test]
    public function hasReturnsFalse(): void
    {
        $faker = self::faker();

        $collection = new TagCollection([new Tag($faker->word())]);

        self::assertFalse($collection->has(new Tag($faker->word())));
    }

    #[Test]
    public function isCountable(): void
    {
        $faker = self::faker();

        $tag = new Tag($faker->word());

        $collection = new TagCollection([$tag]);

        self::assertCount(1, $collection);
    }

    #[Test]
    public function toStringMethod(): void
    {
        $tags = [
            new Tag('field'),
            new Tag('title'),
            new Tag('description'),
        ];

        $collection = new TagCollection($tags);

        self::assertSame('field,title,description', $collection->toString());
    }

    #[Test]
    public function getIterator(): void
    {
        $tags = [
            new Tag('title'),
            new Tag('title'),
        ];

        self::assertInstanceOf(\ArrayIterator::class, (new TagCollection($tags))->getIterator());
    }
}
