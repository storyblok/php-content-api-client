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

namespace Storyblok\Api\Resolver;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
interface ResolverInterface
{
    /**
     * Resolves relations in the target content using the given relations collection.
     *
     * @param array<string, mixed>             $target    the target story content containing UUIDs to resolve
     * @param array<int, array<string, mixed>> $relations the target story content containing UUIDs to resolve
     *
     * @return array<string, mixed>
     */
    public function resolve(array $target, array $relations): array;
}
