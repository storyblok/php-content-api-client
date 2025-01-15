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
use Storyblok\Api\Request\LinksRequest;
use Storyblok\Api\Response\LinksResponse;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 * @author Simon André <smn.andre@gmail.com>
 */
interface LinksApiInterface
{
    public function all(?LinksRequest $request = null): LinksResponse;

    public function byParent(Id $parentId, ?LinksRequest $request = null): LinksResponse;

    public function roots(?LinksRequest $request = null): LinksResponse;
}
