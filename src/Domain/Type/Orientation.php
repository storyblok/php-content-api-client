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

namespace Storyblok\Api\Domain\Type;

use OskarStark\Enum\Trait\Comparable;

/**
 * @experimental This class is experimental and may change in future versions.
 *
 * @author Silas Joisten <silasjoisten@proton.me>
 */
enum Orientation: string
{
    use Comparable;

    case Square = 'square';
    case Landscape = 'landscape';
    case Portrait = 'portrait';
    case Unknown = 'unknown';
}
