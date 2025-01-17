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

namespace Storyblok\Api\Resolver;

final readonly class StoryResolver implements ResolverInterface
{
    public function resolve(array $target, array $relations): array
    {
        //        dd($target, $relations);
        // TODO: Relation resolving here.

        return $target;
    }
}
