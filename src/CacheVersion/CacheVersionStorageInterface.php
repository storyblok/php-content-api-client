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
 *
 * Interface for managing cache version storage.
 *
 * This interface defines methods to get and set the cache version.
 * If the cache version is not set, it should return null.
 */
interface CacheVersionStorageInterface
{
    /**
     * @return null|int returns int if cache version is set, null if not set
     */
    public function get(): ?int;

    /**
     * @param null|int $version Sets the cache version. If null the cache version is unset.
     */
    public function set(?int $version): void;
}
