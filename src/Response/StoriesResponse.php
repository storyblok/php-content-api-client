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

use Storyblok\Api\Domain\Value\Dto\Pagination;
use Storyblok\Api\Domain\Value\Total;
use Webmozart\Assert\Assert;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 */
final readonly class StoriesResponse
{
    /**
     * @var list<array<string, mixed>>
     */
    public array $stories;
    public int $cv;

    /**
     * @var list<array<string, mixed>>
     */
    public array $rels;

    /**
     * @var list<string>
     */
    public array $relUuids;

    /**
     * @var list<array<string, mixed>>
     */
    public array $links;

    /**
     * @param array<string, mixed> $values
     */
    public function __construct(
        public Total $total,
        public Pagination $pagination,
        array $values,
    ) {
        Assert::keyExists($values, 'stories');
        $this->stories = $values['stories'];

        Assert::keyExists($values, 'cv');
        Assert::integer($values['cv']);
        $this->cv = $values['cv'];

        $rels = [];

        if (\array_key_exists('rels', $values)) {
            $rels = $values['rels'];
        }

        $this->rels = $rels;

        $relUuids = [];

        if (\array_key_exists('rel_uuids', $values)) {
            $relUuids = $values['rel_uuids'];
        }

        $this->relUuids = $relUuids;

        Assert::keyExists($values, 'links');
        $this->links = $values['links'];
    }
}
