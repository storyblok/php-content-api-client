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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Resolver;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Resolver\LinkLevel;
use Storyblok\Api\Domain\Value\Resolver\LinkType;
use Storyblok\Api\Domain\Value\Resolver\ResolveLinks;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class ResolveLinksTest extends TestCase
{
    #[Test]
    public function defaults(): void
    {
        $resolveLinks = new ResolveLinks();

        self::assertNull($resolveLinks->type);
        self::assertSame(LinkLevel::Default, $resolveLinks->level);
    }

    #[Test]
    public function fromArray(): void
    {
        $resolveLinks = ResolveLinks::fromArray([
            'type' => 'story',
            'level' => 2,
        ]);

        self::assertSame(LinkType::Story, $resolveLinks->type);
        self::assertSame(LinkLevel::Deep, $resolveLinks->level);
    }

    #[Test]
    public function fromArrayWithNullType(): void
    {
        $resolveLinks = ResolveLinks::fromArray([
            'type' => null,
            'level' => 1,
        ]);

        self::assertNull($resolveLinks->type);
        self::assertSame(LinkLevel::Default, $resolveLinks->level);
    }

    #[Test]
    public function fromArrayWithLinkType(): void
    {
        $resolveLinks = ResolveLinks::fromArray([
            'type' => 'link',
            'level' => 1,
        ]);

        self::assertSame(LinkType::Link, $resolveLinks->type);
        self::assertSame(LinkLevel::Default, $resolveLinks->level);
    }

    #[Test]
    public function fromArrayWithUrlType(): void
    {
        $resolveLinks = ResolveLinks::fromArray([
            'type' => 'url',
            'level' => 2,
        ]);

        self::assertSame(LinkType::Url, $resolveLinks->type);
        self::assertSame(LinkLevel::Deep, $resolveLinks->level);
    }

    #[Test]
    public function fromArrayThrowsExceptionWhenTypeKeyIsMissing(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        ResolveLinks::fromArray([
            'level' => 1,
        ]);
    }

    #[Test]
    public function fromArrayThrowsExceptionWhenLevelKeyIsMissing(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        ResolveLinks::fromArray([
            'type' => 'story',
        ]);
    }

    #[Test]
    public function toArray(): void
    {
        $resolveLinks = new ResolveLinks(LinkType::Story, LinkLevel::Deep);

        self::assertSame([
            'type' => 'story',
            'level' => 2,
        ], $resolveLinks->toArray());
    }

    #[Test]
    public function toArrayWithNullType(): void
    {
        $resolveLinks = new ResolveLinks(null, LinkLevel::Default);

        self::assertSame([
            'type' => null,
            'level' => 1,
        ], $resolveLinks->toArray());
    }

    #[Test]
    public function toArrayWithDefaults(): void
    {
        $resolveLinks = new ResolveLinks();

        self::assertSame([
            'type' => null,
            'level' => 1,
        ], $resolveLinks->toArray());
    }

    #[Test]
    public function roundTrip(): void
    {
        $original = new ResolveLinks(LinkType::Url, LinkLevel::Deep);
        $fromArray = ResolveLinks::fromArray($original->toArray());

        self::assertSame($original->type, $fromArray->type);
        self::assertSame($original->level, $fromArray->level);
    }
}
