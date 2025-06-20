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

namespace Storyblok\Api\Tests\Unit\Domain\Type;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Type\Editable;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class EditableTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function uuid(): void
    {
        $faker = self::faker();
        $values = $faker->editable(uid: $uuid = $faker->uuid());

        self::assertSame($uuid, (new Editable($values))->uuid->value);
    }

    #[Test]
    public function id(): void
    {
        $faker = self::faker();
        $values = $faker->editable(id: $id = (string) $faker->numberBetween(1, 1000));

        self::assertSame((int) $id, (new Editable($values))->id->value);
    }

    #[Test]
    public function validName(): void
    {
        $faker = self::faker();
        $values = $faker->editable(name: $name = $faker->word());

        self::assertSame($name, (new Editable($values))->name);
    }

    #[Test]
    public function space(): void
    {
        $faker = self::faker();
        $values = $faker->editable(space: $space = (string) $faker->randomNumber());

        self::assertSame($space, (new Editable($values))->space);
    }

    #[Test]
    public function stringable(): void
    {
        $values = self::faker()->editable();

        self::assertSame($values, (new Editable($values))->__toString());
        self::assertSame($values, (string) new Editable($values));
    }
}
