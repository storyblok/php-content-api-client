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

namespace Storyblok\Api\Domain\Value\Dto;

/**
 * @author Phil Betley <jpbetley@gmail.com>
 *
 * @see https://www.storyblok.com/docs/api/content-delivery/v2/stories/retrieve-multiple-stories
 */
enum StoryLevel: int
{
    case Root = 1;
    case TopLevel = 2;
    case SecondLevel = 3;
}
