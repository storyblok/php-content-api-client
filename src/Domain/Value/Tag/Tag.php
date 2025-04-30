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

namespace Storyblok\Api\Domain\Value\Tag;

use OskarStark\Value\TrimmedNonEmptyString;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class Tag
{
    public function __construct(
        public string $value,
    ) {
        TrimmedNonEmptyString::fromString($value);
    }
}
