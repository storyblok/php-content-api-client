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
use Storyblok\Api\Domain\Value\Uuid;
use Storyblok\Api\Request\StoriesRequest;
use Storyblok\Api\Resolver\ResolverInterface;
use Storyblok\Api\Response\StoriesResponse;
use Storyblok\Api\Response\StoryResponse;
use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class StoriesResolvedApi implements StoriesApiInterface
{
    public function __construct(
        private StoriesApiInterface $storiesApi,
        private ResolverInterface $resolver,
    ) {
    }

    public function all(?StoriesRequest $request = null): StoriesResponse
    {
        $response = $this->storiesApi->all($request);

        if (null === $request
            || null === $request->withRelations
            || 0 === $request->withRelations->count()
        ) {
            return $response;
        }

        $stories = [];

        foreach ($response->stories as $story) {
            $stories[] = $this->resolver->resolve($story, $response->rels);
        }

        return new StoriesResponse(
            $response->total,
            $response->pagination,
            [
                'cv' => $response->cv,
                'rels' => $response->rels,
                'links' => $response->links,
                'stories' => $stories,
            ],
        );
    }

    public function allByContentType(string $contentType, ?StoriesRequest $request = null): StoriesResponse
    {
        $response = $this->storiesApi->allByContentType($contentType, $request);

        if (null === $request
            || null === $request->withRelations
            || 0 === $request->withRelations->count()
        ) {
            return $response;
        }

        $stories = [];

        foreach ($response->stories as $story) {
            $stories[] = $this->resolver->resolve($story, $response->rels);
        }

        return new StoriesResponse(
            $response->total,
            $response->pagination,
            [
                'cv' => $response->cv,
                'rels' => $response->rels,
                'links' => $response->links,
                'stories' => $stories,
            ],
        );
    }

    public function bySlug(string $slug, string $language = 'default', ?Version $version = null): StoryResponse
    {
        $response = $this->storiesApi->bySlug($slug, $language, $version);

        $story = $this->resolver->resolve($response->story, $response->rels);

        return new StoryResponse([
            'cv' => $response->cv,
            'rels' => $response->rels,
            'links' => $response->links,
            'story' => $story,
        ]);
    }

    public function byUuid(Uuid $uuid, string $language = 'default', ?Version $version = null): StoryResponse
    {
        $response = $this->storiesApi->byUuid($uuid, $language, $version);

        $story = $this->resolver->resolve($response->story, $response->rels);

        return new StoryResponse([
            'cv' => $response->cv,
            'rels' => $response->rels,
            'links' => $response->links,
            'story' => $story,
        ]);
    }

    public function byId(Id $id, string $language = 'default', ?Version $version = null): StoryResponse
    {
        $response = $this->storiesApi->byId($id, $language, $version);

        $story = $this->resolver->resolve($response->story, $response->rels);

        return new StoryResponse([
            'cv' => $response->cv,
            'rels' => $response->rels,
            'links' => $response->links,
            'story' => $story,
        ]);
    }
}
