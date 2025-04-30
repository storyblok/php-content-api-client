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

namespace Storyblok\Api\Domain\Value\Resolver;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 *
 * @see https://www.storyblok.com/docs/api/content-delivery/v2/stories/retrieve-multiple-stories
 */
enum LinkType: string
{
    case Link = 'link';
    case Url = 'url';
    case Story = 'story';
}
