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

namespace Storyblok\Api\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Domain\Value\Id;
use Storyblok\Api\Domain\Value\Total;
use Storyblok\Api\Domain\Value\Uuid;
use Storyblok\Api\Resolver\StoryResolver;
use Storyblok\Api\Response\StoriesResponse;
use Storyblok\Api\Response\StoryResponse;
use Storyblok\Api\StoriesApiInterface;
use Storyblok\Api\StoriesResolvedApi;
use Storyblok\Api\Tests\Util\FakerTrait;

final class StoriesResolvedApiTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function allWithoutRequestResolvesNothing(): void
    {
        $storiesApi = $this->createMock(StoriesApiInterface::class);
        $storiesApi->expects(self::once())
            ->method('all')
            ->willReturn($expected = new StoriesResponse(new Total(3), new Pagination(), [
                'stories' => [],
                'cv' => 0,
                'rels' => [],
                'links' => [],
            ]));

        self::assertSame($expected, (new StoriesResolvedApi($storiesApi, new StoryResolver()))->all());
    }

    #[Test]
    public function allByContentTypeWithoutRequestResolvesNothing(): void
    {
        $storiesApi = $this->createMock(StoriesApiInterface::class);
        $storiesApi->expects(self::once())
            ->method('allByContentType')
            ->willReturn($expected = new StoriesResponse(new Total(3), new Pagination(), [
                'stories' => [],
                'cv' => 0,
                'rels' => [],
                'links' => [],
            ]));

        self::assertSame($expected, (new StoriesResolvedApi($storiesApi, new StoryResolver()))->allByContentType('some-content-type'));
    }

    #[Test]
    public function allByUuidsWithoutRequestResolvesNothing(): void
    {
        $storiesApi = $this->createMock(StoriesApiInterface::class);
        $storiesApi->expects(self::once())
            ->method('allByUuids')
            ->willReturn($expected = new StoriesResponse(new Total(3), new Pagination(), [
                'stories' => [],
                'cv' => 0,
                'rels' => [],
                'links' => [],
            ]));

        self::assertSame($expected, (new StoriesResolvedApi($storiesApi, new StoryResolver()))->allByUuids([self::faker()->uuid()]));
    }

    #[Test]
    public function bySlugWithoutRequestResolvesNothing(): void
    {
        $storiesApi = $this->createMock(StoriesApiInterface::class);
        $storiesApi->expects(self::once())
            ->method('bySlug')
            ->willReturn($expected = new StoryResponse([
                'story' => [],
                'cv' => 0,
                'rels' => [],
                'links' => [],
            ]));

        self::assertSame($expected, (new StoriesResolvedApi($storiesApi, new StoryResolver()))->bySlug(self::faker()->slug()));
    }

    #[Test]
    public function byUuidWithoutRequestResolvesNothing(): void
    {
        $storiesApi = $this->createMock(StoriesApiInterface::class);
        $storiesApi->expects(self::once())
            ->method('byUuid')
            ->willReturn($expected = new StoryResponse([
                'story' => [],
                'cv' => 0,
                'rels' => [],
                'links' => [],
            ]));

        self::assertSame($expected, (new StoriesResolvedApi($storiesApi, new StoryResolver()))->byUuid(new Uuid(self::faker()->uuid())));
    }

    #[Test]
    public function byIdWithoutRequestResolvesNothing(): void
    {
        $storiesApi = $this->createMock(StoriesApiInterface::class);
        $storiesApi->expects(self::once())
            ->method('byId')
            ->willReturn($expected = new StoryResponse([
                'story' => [],
                'cv' => 0,
                'rels' => [],
                'links' => [],
            ]));

        self::assertSame($expected, (new StoriesResolvedApi($storiesApi, new StoryResolver()))->byId(new Id(self::faker()->numberBetween(1, 5))));
    }
}
