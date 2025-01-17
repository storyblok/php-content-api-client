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

namespace Storyblok\Api;

use Storyblok\Api\Domain\Value\Dto\Version;
use Storyblok\Api\Domain\Value\Id;
use Storyblok\Api\Domain\Value\Resolver\RelationCollection;
use Storyblok\Api\Domain\Value\Total;
use Storyblok\Api\Domain\Value\Uuid;
use Storyblok\Api\Request\StoriesRequest;
use Storyblok\Api\Request\StoryRequest;
use Storyblok\Api\Response\StoriesResponse;
use Storyblok\Api\Response\StoryResponse;
use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
final class StoriesApi implements StoriesApiInterface
{
    private const string ENDPOINT = '/v2/cdn/stories';
    private Version $version;

    /**
     * @param 'draft'|'published' $version
     */
    public function __construct(
        private StoryblokClientInterface $client,
        string $version = 'published', // we inject a string here, because Symfony DI does not support enums
    ) {
        $this->version = Version::from($version);
    }

    public function all(?StoriesRequest $request = null): StoriesResponse
    {
        $request ??= new StoriesRequest();

        $response = $this->client->request('GET', self::ENDPOINT, [
            'query' => [
                ...$request->toArray(),
                'version' => null !== $request->version ? $request->version->value : $this->version->value,
            ],
        ]);

        return new StoriesResponse(
            Total::fromHeaders($response->getHeaders()),
            $request->pagination,
            $response->toArray(),
        );
    }

    public function allByContentType(string $contentType, ?StoriesRequest $request = null): StoriesResponse
    {
        Assert::stringNotEmpty($contentType);

        $request ??= new StoriesRequest();

        $response = $this->client->request('GET', self::ENDPOINT, [
            'query' => [
                ...$request->toArray(),
                'content_type' => $contentType,
                'version' => null !== $request->version ? $request->version->value : $this->version->value,
            ],
        ]);

        return new StoriesResponse(
            Total::fromHeaders($response->getHeaders()),
            $request->pagination,
            $response->toArray(),
        );
    }

    public function bySlug(string $slug, ?StoryRequest $request = null): StoryResponse
    {
        Assert::stringNotEmpty($slug);

        $request ??= new StoryRequest();

        $response = $this->client->request('GET', \sprintf('%s/%s', self::ENDPOINT, $slug), [
            'query' => [
                ...$request->toArray(),
                'version' => null !== $request->version ? $request->version->value : $this->version->value,
            ],
        ]);

        return new StoryResponse($response->toArray());
    }

    public function byUuid(Uuid $uuid, ?StoryRequest $request = null): StoryResponse
    {
        $request ??= new StoryRequest();

        $response = $this->client->request('GET', \sprintf('%s/%s', self::ENDPOINT, $uuid->value), [
            'query' => [
                ...$request->toArray(),
                'find_by' => 'uuid',
                'version' => null !== $request->version ? $request->version->value : $this->version->value,
            ],
        ]);

        return new StoryResponse($response->toArray());
    }

    public function byId(Id $id, ?StoryRequest $request = null): StoryResponse
    {
        $request ??= new StoryRequest();

        $response = $this->client->request('GET', \sprintf('/v2/cdn/stories/%s', $id->value), [
            'query' => [
                ...$request->toArray(),
                'version' => null !== $request->version ? $request->version->value : $this->version->value,
            ],
        ]);

        return new StoryResponse($response->toArray());
    }
}
