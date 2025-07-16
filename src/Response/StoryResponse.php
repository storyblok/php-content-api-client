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

namespace Storyblok\Api\Response;

use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class StoryResponse
{
    /**
     * @var array<string, mixed>
     */
    public array $story;
    public int $cv;

    /**
     * @var list<array<string, mixed>>
     */
    public array $rels;

    /**
     * @var list<array<string,mixed>>
     */
    public array $links;

    /**
     * @param array<string, mixed> $values
     */
    public function __construct(array $values)
    {
        Assert::keyExists($values, 'story');
        $this->story = $values['story'];

        Assert::keyExists($values, 'cv');
        Assert::integer($values['cv']);
        $this->cv = $values['cv'];

        Assert::keyExists($values, 'rels');
        $this->rels = $values['rels'];

        Assert::keyExists($values, 'links');
        $this->links = $values['links'];
    }
}
