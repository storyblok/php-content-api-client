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

namespace Storyblok\Api\Tests\Unit\Resolver;

use OskarStark\Enum\Test\EnumTestCase;
use Storyblok\Api\Domain\Value\Resolver\LinkLevel;

final class LinkLevelTest extends EnumTestCase
{
    protected static function getClass(): string
    {
        return LinkLevel::class;
    }

    protected static function getNumberOfValues(): int
    {
        return 2;
    }
}
