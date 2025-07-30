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

namespace Storyblok\Api\Tests\Unit\CacheVersion;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Storyblok\Api\CacheVersion\InMemoryStorage;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final class InMemoryStorageTest extends TestCase
{
    #[DataProvider('values')]
    #[Test]
    public function setAndGetWithValues(?int $value): void
    {
        $storage = new InMemoryStorage();
        $storage->set($value);

        self::assertSame($value, $storage->get());
    }

    /**
     * @return iterable<int, ?int>
     */
    public static function values(): iterable
    {
        yield [12];
        yield [0];
        yield [null];
    }
}
