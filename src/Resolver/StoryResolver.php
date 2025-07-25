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
        $seen = [];

        foreach ($relations as $relation) {
            Assert::keyExists($relation, 'uuid');
            Assert::uuid($relation['uuid']);
            $relationMap[$relation['uuid']] = $relation;
        }

        return $this->doResolve($target, $relationMap, []);
    }

    private function doResolve(array $target, array $relationMap, array $seen): array
    {
        foreach ($target as $key => $value) {
            if (\is_string($value) && isset($relationMap[$value])) {
                if (\in_array($value, $seen, true)) {
                    continue;
                }

                $seen[] = $value;
                $target[$key] = $this->doResolve($relationMap[$value], $relationMap, $seen);
            } elseif (\is_array($value) && isset($value['id'], $relationMap[$value['id']])) {
                $id = $value['id'];

                if (\in_array($id, $seen, true)) {
                    continue;
                }

                $seen[] = $id;
                $target[$key] = $this->doResolve($relationMap[$id], $relationMap, $seen);
            } elseif (\is_array($value)) {
                $target[$key] = $this->doResolve($value, $relationMap, $seen);
            }
        }

        return $target;
    }
}
