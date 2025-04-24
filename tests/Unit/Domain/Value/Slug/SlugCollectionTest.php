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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Slug;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Slug\Slug;
use Storyblok\Api\Domain\Value\Slug\SlugCollection;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class SlugCollectionTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function constructWithString(): void
    {
        $faker = self::faker();
        $collection = new SlugCollection([$faker->word(), $faker->word()]);

        self::assertCount(2, $collection);
        self::assertContainsOnlyInstancesOf(Slug::class, $collection);
    }

    #[Test]
    public function add(): void
    {
        $faker = self::faker();

        $collection = new SlugCollection();
        self::assertEmpty($collection);

        $collection->add(new Slug($faker->word()));
        self::assertCount(1, $collection);
    }

    #[Test]
    public function remove(): void
    {
        $faker = self::faker();

        $slug = new Slug($faker->word());

        $collection = new SlugCollection([$slug]);
        self::assertCount(1, $collection);

        $collection->remove($slug);
        self::assertEmpty($collection);
    }

    #[Test]
    public function hasReturnsTrue(): void
    {
        $faker = self::faker();

        $slug = new Slug($faker->word());

        $collection = new SlugCollection([$slug, new Slug($faker->word())]);

        self::assertTrue($collection->has($slug));
    }

    #[Test]
    public function hasReturnsFalse(): void
    {
        $faker = self::faker();

        $collection = new SlugCollection([new Slug($faker->word())]);

        self::assertFalse($collection->has(new Slug($faker->word())));
    }

    #[Test]
    public function isCountable(): void
    {
        $faker = self::faker();

        $slug = new Slug($faker->word());

        $collection = new SlugCollection([$slug]);

        self::assertCount(1, $collection);
    }

    #[Test]
    public function toStringMethod(): void
    {
        $slugs = [
            new Slug('foo/*'),
            new Slug('test/bar'),
            new Slug('baz/bar/*'),
        ];

        $collection = new SlugCollection($slugs);

        self::assertSame('foo/*,test/bar,baz/bar/*', $collection->toString());
    }

    #[Test]
    public function getIterator(): void
    {
        $slugs = [
            new Slug('foo'),
            new Slug('bar/baz'),
        ];

        self::assertInstanceOf(\ArrayIterator::class, (new SlugCollection($slugs))->getIterator());
    }
}
