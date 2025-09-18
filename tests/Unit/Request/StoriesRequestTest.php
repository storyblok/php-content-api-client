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
use Storyblok\Api\Domain\Value\Dto\Direction;
use Storyblok\Api\Domain\Value\Dto\SortBy;
use Storyblok\Api\Domain\Value\Dto\Version;
use Storyblok\Api\Domain\Value\Field\Field;
use Storyblok\Api\Domain\Value\Field\FieldCollection;
use Storyblok\Api\Domain\Value\Filter\FilterCollection;
use Storyblok\Api\Domain\Value\Filter\Filters\InFilter;
use Storyblok\Api\Domain\Value\Id;
use Storyblok\Api\Domain\Value\IdCollection;
use Storyblok\Api\Domain\Value\QueryParameter\FirstPublishedAtGt;
use Storyblok\Api\Domain\Value\QueryParameter\FirstPublishedAtLt;
use Storyblok\Api\Domain\Value\QueryParameter\PublishedAtGt;
use Storyblok\Api\Domain\Value\QueryParameter\PublishedAtLt;
use Storyblok\Api\Domain\Value\QueryParameter\UpdatedAtGt;
use Storyblok\Api\Domain\Value\QueryParameter\UpdatedAtLt;
use Storyblok\Api\Domain\Value\Resolver\Relation;
use Storyblok\Api\Domain\Value\Resolver\RelationCollection;
use Storyblok\Api\Domain\Value\Slug\Slug;
use Storyblok\Api\Domain\Value\Slug\SlugCollection;
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
    private const string EXPECTED_DATE_TIME_FORMAT = 'Y-m-d\TH:i:s.v\Z';

    #[Test]
    public function toArrayWithDefaults(): void
    {
        $request = new StoriesRequest();

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
        ], $request->toArray());
    }

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
    public function toArrayWithSearchTerm(): void
    {
        $request = new StoriesRequest(
            searchTerm: $searchTerm = self::faker()->word(),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'search_term' => $searchTerm,
        ], $request->toArray());
    }

    #[Test]
    public function toArrayExcludeSlugs(): void
    {
        $request = new StoriesRequest(
            excludeSlugs: new SlugCollection([
                new Slug('path/*'),
                new Slug('another-path/*'),
            ]),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'excluding_slugs' => 'path/*,another-path/*',
        ], $request->toArray());
    }

    #[Test]
    public function toArrayStartsWith(): void
    {
        $request = new StoriesRequest(
            startsWith: new Slug('my/path'),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'starts_with' => 'my/path',
        ], $request->toArray());
    }

    #[Test]
    public function toArrayWithPublishedAtGt(): void
    {
        $faker = self::faker();

        $date = $faker->dateTime();
        $expectedDate = $date->format(self::EXPECTED_DATE_TIME_FORMAT);

        $request = new StoriesRequest(
            publishedAtGt: new PublishedAtGt($date),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'published_at_gt' => $expectedDate,
        ], $request->toArray());
    }

    #[Test]
    public function toArrayWithPublishedAtLt(): void
    {
        $faker = self::faker();

        $date = $faker->dateTime();
        $expectedDate = $date->format(self::EXPECTED_DATE_TIME_FORMAT);

        $request = new StoriesRequest(
            publishedAtLt: new PublishedAtLt($date),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'published_at_lt' => $expectedDate,
        ], $request->toArray());
    }

    #[Test]
    public function toArrayWithFirstPublishedAtGt(): void
    {
        $faker = self::faker();

        $date = $faker->dateTime();
        $expectedDate = $date->format(self::EXPECTED_DATE_TIME_FORMAT);

        $request = new StoriesRequest(
            firstPublishedAtGt: new FirstPublishedAtGt($date),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'first_published_at_gt' => $expectedDate,
        ], $request->toArray());
    }

    #[Test]
    public function toArrayWithFirstPublishedAtLt(): void
    {
        $faker = self::faker();

        $date = $faker->dateTime();
        $expectedDate = $date->format(self::EXPECTED_DATE_TIME_FORMAT);

        $request = new StoriesRequest(
            firstPublishedAtLt: new FirstPublishedAtLt($date),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'first_published_at_lt' => $expectedDate,
        ], $request->toArray());
    }

    #[Test]
    public function toArrayWithUpdatedAtGt(): void
    {
        $faker = self::faker();

        $date = $faker->dateTime();
        $expectedDate = $date->format(self::EXPECTED_DATE_TIME_FORMAT);

        $request = new StoriesRequest(
            updatedAtGt: new UpdatedAtGt($date),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'updated_at_gt' => $expectedDate,
        ], $request->toArray());
    }

    #[Test]
    public function toArrayWithUpdatedAtLt(): void
    {
        $faker = self::faker();

        $date = $faker->dateTime();
        $expectedDate = $date->format(self::EXPECTED_DATE_TIME_FORMAT);

        $request = new StoriesRequest(
            updatedAtLt: new UpdatedAtLt($date),
        );

        self::assertSame([
            'language' => 'default',
            'page' => 1,
            'per_page' => 25,
            'updated_at_lt' => $expectedDate,
        ], $request->toArray());
    }
}
