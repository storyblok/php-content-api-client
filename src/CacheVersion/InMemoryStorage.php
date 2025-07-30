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

namespace Storyblok\Api\CacheVersion;

/**
 * @experimental
 */
final class InMemoryStorage implements CacheVersionStorageInterface
{
    private ?int $cacheVersion = null;

    public function get(): ?int
    {
        return $this->cacheVersion;
    }

    public function set(?int $version): void
    {
        $this->cacheVersion = $version;
    }
}
