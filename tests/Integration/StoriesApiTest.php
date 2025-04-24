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

namespace Storyblok\Api\Tests\Integration;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Id;
use Storyblok\Api\Domain\Value\Uuid;
use Storyblok\Api\Response\StoriesResponse;
use Storyblok\Api\Response\StoryResponse;
use Storyblok\Api\StoriesApi;
use Storyblok\Api\Tests\Util\FakerTrait;
use Storyblok\Api\Tests\Util\StoryblokFakeClient;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class StoriesApiTest extends TestCase
{
    use FakerTrait;

    #[Test]
    public function allStoriesAreRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->storiesResponse(),
            ['total' => 1],
        );
        $api = new StoriesApi($client);

        $response = $api->all();

        self::assertInstanceOf(StoriesResponse::class, $response);
        self::assertSame(1, $response->total->value);
    }

    #[Test]
    public function allStoriesByContentTypeAreRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->storiesResponse(),
            ['total' => 1],
        );
        $api = new StoriesApi($client);

        $response = $api->allByContentType(self::faker()->word());

        self::assertInstanceOf(StoriesResponse::class, $response);
        self::assertSame(1, $response->total->value);
    }

    #[Test]
    public function allStoriesByUuidsAreRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->storiesResponse(),
            ['total' => 1],
        );
        $api = new StoriesApi($client);

        $response = $api->allByUuids([new Uuid(self::faker()->uuid())]);

        self::assertInstanceOf(StoriesResponse::class, $response);
        self::assertSame(1, $response->total->value);
    }

    #[Test]
    public function storyBySlugIsRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->storyResponse(),
        );
        $api = new StoriesApi($client);

        $response = $api->bySlug('test-slug');

        self::assertInstanceOf(StoryResponse::class, $response);
    }

    #[Test]
    public function storyByUuidIsRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->storyResponse(),
        );
        $api = new StoriesApi($client);

        $response = $api->byUuid(new Uuid(self::faker()->uuid()));

        self::assertInstanceOf(StoryResponse::class, $response);
    }

    #[Test]
    public function storyByIdIsRetrievedSuccessfully(): void
    {
        $client = StoryblokFakeClient::willRespond(
            self::faker()->storyResponse(),
        );
        $api = new StoriesApi($client);

        $response = $api->byId(new Id(14));

        self::assertInstanceOf(StoryResponse::class, $response);
    }

    #[Test]
    public function exceptionIsThrownWhenRetrievingAllStoriesFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new StoriesApi($client);

        self::expectException(\Exception::class);

        $api->all();
    }

    #[Test]
    public function exceptionIsThrownWhenRetrievingAllStoriesByContentTypeFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new StoriesApi($client);

        self::expectException(\Exception::class);

        $api->allByContentType(self::faker()->word());
    }

    #[Test]
    public function exceptionIsThrownWhenRetrievingAllStoriesByIdFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new StoriesApi($client);

        self::expectException(\Exception::class);

        $api->byId(new Id(self::faker()->numberBetween(1)));
    }

    #[Test]
    public function exceptionIsThrownWhenRetrievingAllStoriesByUuidFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new StoriesApi($client);

        self::expectException(\Exception::class);

        $api->byUuid(new Uuid(self::faker()->uuid()));
    }

    #[Test]
    public function exceptionIsThrownWhenRetrievingAllStoriesBySlugFails(): void
    {
        $client = StoryblokFakeClient::willThrowException(new \Exception());
        $api = new StoriesApi($client);

        self::expectException(\Exception::class);

        $api->bySlug(self::faker()->slug());
    }
}
