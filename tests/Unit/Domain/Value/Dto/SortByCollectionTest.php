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

namespace Storyblok\Api\Tests\Unit\Domain\Value\Dto;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\Domain\Value\Dto\Direction;
use Storyblok\Api\Domain\Value\Dto\SortBy;
use Storyblok\Api\Domain\Value\Dto\SortByCollection;

final class SortByCollectionTest extends TestCase
{
    #[Test]
    public function toStringMethod(): void
    {
        $collection = new SortByCollection([
            new SortBy('name', Direction::Desc),
            new SortBy('slug', Direction::Asc),
        ]);

        self::assertSame('name:desc,slug:asc', $collection->toString());
    }
}
