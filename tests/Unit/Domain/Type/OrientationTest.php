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

namespace Storyblok\Api\Tests\Unit\Domain\Type;

use OskarStark\Enum\Test\EnumTestCase;
use Storyblok\Api\Domain\Type\Orientation;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class OrientationTest extends EnumTestCase
{
    protected static function getClass(): string
    {
        return Orientation::class;
    }

    protected static function getNumberOfValues(): int
    {
        return 4;
    }
}
