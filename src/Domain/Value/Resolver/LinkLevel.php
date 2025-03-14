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

namespace Storyblok\Api\Domain\Value\Resolver;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 *
 * @see https://www.storyblok.com/docs/api/content-delivery/v2/stories/retrieve-multiple-stories
 */
enum LinkLevel: int
{
    case Default = 1;
    case Deep = 2;
}
