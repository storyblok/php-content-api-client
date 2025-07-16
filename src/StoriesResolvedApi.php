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

namespace Storyblok\Api;

use Storyblok\Api\Domain\Value\Id;
use Storyblok\Api\Domain\Value\Resolver\LinkType;
use Storyblok\Api\Domain\Value\Uuid;
use Storyblok\Api\Request\StoriesRequest;
use Storyblok\Api\Request\StoryRequest;
use Storyblok\Api\Resolver\ResolverInterface;
use Storyblok\Api\Response\StoriesResponse;
use Storyblok\Api\Response\StoryResponse;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class StoriesResolvedApi implements StoriesApiInterface
{
    public function __construct(
        private StoriesApiInterface $storiesApi,
        private ResolverInterface $resolver,
        private bool $resolveRelations = false,
        private bool $resolveLinks = false,
    ) {
    }

    public function all(?StoriesRequest $request = null): StoriesResponse
    {
        $response = $this->storiesApi->all($request);

        if (null === $request) {
            return $response;
        }

        $stories = [];

        foreach ($response->stories as $story) {
            $resolvedStory = $story;

            if ($this->resolveRelations && 0 !== $request->withRelations->count()) {
                // There is a limit of possible resolvable relations.
                // @see https://www.storyblok.com/docs/api/content-delivery/v2/stories/retrieve-a-single-story
                $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->rels, 0, 50));
            }

            if ($this->resolveLinks && null !== $request->resolveLinks->type) {
                // There is a limit of possible resolvable relations.
                // @see https://www.storyblok.com/docs/guide/in-depth/rendering-the-link-field
                $limit = match ($request->resolveLinks->type) {
                    LinkType::Story => 50,
                    LinkType::Link, LinkType::Url => 500,
                };

                $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->links, 0, $limit));
            }

            $stories[] = $resolvedStory;
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

        if (null === $request) {
            return $response;
        }

        $stories = [];

        foreach ($response->stories as $story) {
            $resolvedStory = $story;

            if ($this->resolveRelations && 0 !== $request->withRelations->count()) {
                // There is a limit of possible resolvable relations.
                // @see https://www.storyblok.com/docs/api/content-delivery/v2/stories/retrieve-a-single-story
                $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->rels, 0, 50));
            }

            if ($this->resolveLinks && null !== $request->resolveLinks->type) {
                // There is a limit of possible resolvable relations.
                // @see https://www.storyblok.com/docs/guide/in-depth/rendering-the-link-field
                $limit = match ($request->resolveLinks->type) {
                    LinkType::Story => 50,
                    LinkType::Link, LinkType::Url => 500,
                };

                $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->links, 0, $limit));
            }

            $stories[] = $resolvedStory;
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

    public function allByUuids(array $uuids, bool $keepOrder = true, ?StoriesRequest $request = null): StoriesResponse
    {
        $response = $this->storiesApi->allByUuids($uuids, $keepOrder, $request);

        if (null === $request) {
            return $response;
        }

        $stories = [];

        foreach ($response->stories as $story) {
            $resolvedStory = $story;

            if ($this->resolveRelations && 0 !== $request->withRelations->count()) {
                // There is a limit of possible resolvable relations.
                // @see https://www.storyblok.com/docs/api/content-delivery/v2/stories/retrieve-a-single-story
                $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->rels, 0, 50));
            }

            if ($this->resolveLinks && null !== $request->resolveLinks->type) {
                // There is a limit of possible resolvable relations.
                // @see https://www.storyblok.com/docs/guide/in-depth/rendering-the-link-field
                $limit = match ($request->resolveLinks->type) {
                    LinkType::Story => 50,
                    LinkType::Link, LinkType::Url => 500,
                };

                $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->links, 0, $limit));
            }

            $stories[] = $resolvedStory;
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

    public function bySlug(string $slug, ?StoryRequest $request = null): StoryResponse
    {
        $response = $this->storiesApi->bySlug($slug, $request);

        $resolvedStory = $response->story;

        if ($this->resolveRelations && 0 !== $request->withRelations->count()) {
            // There is a limit of possible resolvable relations.
            // @see https://www.storyblok.com/docs/api/content-delivery/v2/stories/retrieve-a-single-story
            $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->rels, 0, 50));
        }

        if ($this->resolveLinks && null !== $request->resolveLinks->type) {
            // There is a limit of possible resolvable relations.
            // @see https://www.storyblok.com/docs/guide/in-depth/rendering-the-link-field
            $limit = match ($request->resolveLinks->type) {
                LinkType::Story => 50,
                LinkType::Link, LinkType::Url => 500,
            };

            $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->links, 0, $limit));
        }

        return new StoryResponse([
            'cv' => $response->cv,
            'rels' => $response->rels,
            'links' => $response->links,
            'story' => $resolvedStory,
        ]);
    }

    public function byUuid(Uuid $uuid, ?StoryRequest $request = null): StoryResponse
    {
        $response = $this->storiesApi->byUuid($uuid, $request);

        $resolvedStory = $response->story;

        if ($this->resolveRelations && 0 !== $request->withRelations->count()) {
            // There is a limit of possible resolvable relations.
            // @see https://www.storyblok.com/docs/api/content-delivery/v2/stories/retrieve-a-single-story
            $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->rels, 0, 50));
        }

        if ($this->resolveLinks && null !== $request->resolveLinks->type) {
            // There is a limit of possible resolvable relations.
            // @see https://www.storyblok.com/docs/guide/in-depth/rendering-the-link-field
            $limit = match ($request->resolveLinks->type) {
                LinkType::Story => 50,
                LinkType::Link, LinkType::Url => 500,
            };

            $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->links, 0, $limit));
        }

        return new StoryResponse([
            'cv' => $response->cv,
            'rels' => $response->rels,
            'links' => $response->links,
            'story' => $resolvedStory,
        ]);
    }

    public function byId(Id $id, ?StoryRequest $request = null): StoryResponse
    {
        $response = $this->storiesApi->byId($id, $request);

        $resolvedStory = $response->story;

        if ($this->resolveRelations && 0 !== $request->withRelations->count()) {
            // There is a limit of possible resolvable relations.
            // @see https://www.storyblok.com/docs/api/content-delivery/v2/stories/retrieve-a-single-story
            $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->rels, 0, 50));
        }

        if ($this->resolveLinks && null !== $request->resolveLinks->type) {
            // There is a limit of possible resolvable relations.
            // @see https://www.storyblok.com/docs/guide/in-depth/rendering-the-link-field
            $limit = match ($request->resolveLinks->type) {
                LinkType::Story => 50,
                LinkType::Link, LinkType::Url => 500,
            };

            $resolvedStory = $this->resolver->resolve($resolvedStory, \array_slice($response->links, 0, $limit));
        }

        return new StoryResponse([
            'cv' => $response->cv,
            'rels' => $response->rels,
            'links' => $response->links,
            'story' => $resolvedStory,
        ]);
    }
}
