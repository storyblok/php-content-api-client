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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Field;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Field\Field;
use Storyblok\Api\Domain\Value\Field\FieldCollection;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class FieldCollectionTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function constructWithString(): void
    {
        $faker = self::faker();
        $collection = new FieldCollection([$faker->word(), $faker->word()]);

        self::assertCount(2, $collection);
        self::assertContainsOnlyInstancesOf(Field::class, $collection);
    }

    #[Test]
    public function add(): void
    {
        $faker = self::faker();

        $collection = new FieldCollection();
        self::assertEmpty($collection);

        $collection->add(new Field($faker->word()));
        self::assertCount(1, $collection);
    }

    #[Test]
    public function remove(): void
    {
        $faker = self::faker();

        $field = new Field($faker->word());

        $collection = new FieldCollection([$field]);
        self::assertCount(1, $collection);

        $collection->remove($field);
        self::assertEmpty($collection);
    }

    #[Test]
    public function hasReturnsTrue(): void
    {
        $faker = self::faker();

        $field = new Field($faker->word());

        $collection = new FieldCollection([$field, new Field($faker->word())]);

        self::assertTrue($collection->has($field));
    }

    #[Test]
    public function hasReturnsFalse(): void
    {
        $faker = self::faker();

        $collection = new FieldCollection([new Field($faker->word())]);

        self::assertFalse($collection->has(new Field($faker->word())));
    }

    #[Test]
    public function isCountable(): void
    {
        $faker = self::faker();

        $field = new Field($faker->word());

        $collection = new FieldCollection([$field]);

        self::assertCount(1, $collection);
    }

    #[Test]
    public function toStringMethod(): void
    {
        $fields = [
            new Field('field'),
            new Field('title'),
            new Field('description'),
        ];

        $collection = new FieldCollection($fields);

        self::assertSame('field,title,description', $collection->toString());
    }

    #[Test]
    public function getIterator(): void
    {
        $fields = [
            new Field('title'),
            new Field('title'),
        ];

        self::assertInstanceOf(\ArrayIterator::class, (new FieldCollection($fields))->getIterator());
    }
}
