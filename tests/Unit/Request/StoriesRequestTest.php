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

namespace Storyblok\Api\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Dto\Direction;
use Storyblok\Api\Domain\Value\Dto\SortBy;
use Storyblok\Api\Domain\Value\Dto\Version;
use Storyblok\Api\Domain\Value\Field\Field;
use Storyblok\Api\Domain\Value\Field\FieldCollection;
use Storyblok\Api\Domain\Value\Filter\FilterCollection;
use Storyblok\Api\Domain\Value\Filter\Filters\InFilter;
use Storyblok\Api\Domain\Value\Id;
use Storyblok\Api\Domain\Value\IdCollection;
use Storyblok\Api\Domain\Value\Resolver\Relation;
use Storyblok\Api\Domain\Value\Resolver\RelationCollection;
use Storyblok\Api\Domain\Value\Tag\Tag;
use Storyblok\Api\Domain\Value\Tag\TagCollection;
use Storyblok\Api\Request\StoriesRequest;
use Storyblok\Api\Tests\Util\FakerTrait;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class StoriesRequestTest extends TestCase
{
    use FakerTrait;

    /**
     * @test
     */
    public function toArrayWithDefaults(): void
    {
        $request = new StoriesRequest();

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function toArrayWithSortBy(): void
    {
        $request = new StoriesRequest(
            sortBy: new SortBy('name', Direction::Asc),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'sort_by' => 'name:asc',
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function toArrayWithFilters(): void
    {
        $request = new StoriesRequest(
            filters: new FilterCollection([
                new InFilter('name', ['foo', 'bar']),
            ]),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'filter_query' => [
                'name' => [
                    'in' => 'foo,bar',
                ],
            ],
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function toArrayWithExcludeFields(): void
    {
        $request = new StoriesRequest(
            excludeFields: new FieldCollection([
                new Field('body'),
                new Field('content'),
            ]),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'excluding_fields' => 'body,content',
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function toArrayWithTags(): void
    {
        $request = new StoriesRequest(
            withTags: new TagCollection([
                new Tag('foo'),
                new Tag('bar'),
            ]),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'with_tag' => 'foo,bar',
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function toArrayWithExcludeIds(): void
    {
        $request = new StoriesRequest(
            excludeIds: new IdCollection([
                new Id(1),
            ]),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'excluding_ids' => '1',
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function toArrayWithRelations(): void
    {
        $request = new StoriesRequest(
            withRelations: new RelationCollection([
                new Relation('blog_post.category'),
            ]),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'resolve_relations' => 'blog_post.category',
        ], $request->toArray());
    }

    /**
     * @test
     */
    public function toArrayWithVersion(): void
    {
        $request = new StoriesRequest(
            version: $version = Version::Published,
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'version' => $version->value,
        ], $request->toArray());
    }
}
