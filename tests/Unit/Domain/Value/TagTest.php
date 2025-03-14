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

namespace Storyblok\Api\Tests\Unit\Domain\Value;

use Ergebnis\DataProvider\StringProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Tag;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class TagTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function nameValue(): void
    {
        $value = self::faker()->word();
        $tag = new Tag($value, 0);

        self::assertSame($value, $tag->name);
    }

    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[Test]
    public function nameInvalid(string $value): void
    {
        self::expectException(\InvalidArgumentException::class);

        new Tag($value, 0);
    }

    #[Test]
    public function taggingsCount(): void
    {
        $word = self::faker()->word();
        $value = self::faker()->numberBetween(1, 10000);

        self::assertSame($value, (new Tag($word, $value))->taggingsCount);
    }

    #[Test]
    public function taggingsCountCanBeZero(): void
    {
        $word = self::faker()->word();

        self::assertSame(0, (new Tag($word, 0))->taggingsCount);
    }

    #[Test]
    public function taggingCountMustBeGreaterThanOrEqualZero(): void
    {
        $word = self::faker()->word();
        self::expectException(\InvalidArgumentException::class);

        new Tag($word, -1);
    }
}
