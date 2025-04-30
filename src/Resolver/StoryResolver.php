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

        foreach ($relations as $key => $relation) {
            Assert::keyExists($relation, 'uuid');
            Assert::uuid($relation['uuid']);
            $relationMap[$relation['uuid']] = $relation;

            // There is a limit of possible resolvable relations.
            // @see https://www.storyblok.com/docs/api/content-delivery/v2/stories/retrieve-a-single-story
            if (50 === $key) {
                break;
            }
        }

        foreach ($target as &$value) {
            if (\is_string($value) && \array_key_exists($value, $relationMap)) {
                $value = $relationMap[$value];

                continue;
            }

            if (\is_array($value)) {
                $value = $this->resolve($value, $relations);
            }
        }

        return $target;
    }
}
