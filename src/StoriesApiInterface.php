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

use Storyblok\Api\Domain\Value\Id;
use Storyblok\Api\Domain\Value\Uuid;
use Storyblok\Api\Request\StoriesRequest;
use Storyblok\Api\Request\StoryRequest;
use Storyblok\Api\Response\StoriesResponse;
use Storyblok\Api\Response\StoryResponse;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
interface StoriesApiInterface
{
    public const int MAX_PER_PAGE = 100;

    public function all(?StoriesRequest $request = null): StoriesResponse;

    public function allByContentType(string $contentType, ?StoriesRequest $request = null): StoriesResponse;

    /**
     * @param Uuid[] $uuids
     */
    public function allByUuids(array $uuids, bool $keepOrder = true, ?StoriesRequest $request = null): StoriesResponse;

    public function bySlug(string $slug, ?StoryRequest $request = null): StoryResponse;

    public function byUuid(Uuid $uuid, ?StoryRequest $request = null): StoryResponse;

    public function byId(Id $id, ?StoryRequest $request = null): StoryResponse;
}
