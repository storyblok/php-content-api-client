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

use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class StoryResolver implements ResolverInterface
{
    public function resolve(array $target, array $relations): array
    {
        $relationMap = [];

        foreach ($relations as $relation) {
            Assert::keyExists($relation, 'uuid');
            Assert::uuid($relation['uuid']);
            $relationMap[$relation['uuid']] = $relation;
        }

        // Resolve relations within the relation map first
        $this->doResolve($relationMap, $relationMap);

        // Then resolve relations in the main target
        $this->doResolve($target, $relationMap);

        return $target;
    }

    private function doResolve(array &$target, array &$relationMap): void
    {
        foreach ($target as $key => &$value) {
            if ('uuid' === $key) {
                continue;
            }

            if (\is_string($value) && isset($relationMap[$value])) {
                $value = $relationMap[$value];
            } elseif (\is_array($value) && isset($value['id'], $relationMap[$value['id']])) {
                $value = $relationMap[$value['id']];
            } elseif (\is_array($value)) {
                $this->doResolve($value, $relationMap);
            }
        }
    }
}
