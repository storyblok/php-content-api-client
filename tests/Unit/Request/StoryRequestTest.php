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

namespace Storyblok\Api\Tests\Unit\Request;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Dto\Version;
use Storyblok\Api\Domain\Value\Resolver\LinkLevel;
use Storyblok\Api\Domain\Value\Resolver\LinkType;
use Storyblok\Api\Domain\Value\Resolver\Relation;
use Storyblok\Api\Domain\Value\Resolver\RelationCollection;
use Storyblok\Api\Domain\Value\Resolver\ResolveLinks;
use Storyblok\Api\Request\StoryRequest;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class StoryRequestTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function toArray(): void
    {
        $request = new StoryRequest(
            language: $language = self::faker()->word(),
            version: $version = Version::Published,
        );

        self::assertSame([
            'language' => $language,
            'version' => $version->value,
        ], $request->toArray());
    }

    #[Test]
    public function toArrayWithDefaults(): void
    {
        $request = new StoryRequest();

        self::assertSame([
            'language' => 'default',
        ], $request->toArray());
    }

    #[Test]
    public function toArrayWithVersion(): void
    {
        $request = new StoryRequest(
            version: $version = Version::Published,
        );

        self::assertSame([
            'language' => 'default',
            'version' => $version->value,
        ], $request->toArray());
    }

    #[Test]
    public function toArrayWithRelations(): void
    {
        $request = new StoryRequest(
            withRelations: new RelationCollection([
                new Relation('root.relation'),
                new Relation('root.another_relation'),
            ]),
        );

        self::assertSame([
            'language' => 'default',
            'resolve_relations' => 'root.relation,root.another_relation',
        ], $request->toArray());
    }

    #[Test]
    public function toArrayResolveLinks(): void
    {
        $request = new StoryRequest(
            resolveLinks: new ResolveLinks(LinkType::Story, LinkLevel::Deep),
        );

        self::assertSame([
            'language' => 'default',
            'resolve_links' => 'story',
            'resolve_links_level' => 2,
        ], $request->toArray());
    }
}
