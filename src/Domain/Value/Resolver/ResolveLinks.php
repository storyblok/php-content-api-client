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

final readonly class ResolveLinks
{
    public function __construct(
        public ?LinkType $type = null,
        public LinkLevel $level = LinkLevel::Default,
    ) {
    }
}
