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

namespace Storyblok\Api\Domain\Value\Dto;

/**
 * @implements \IteratorAggregate<int, SortBy>
 */
final class SortByCollection implements \Countable, \IteratorAggregate
{
    /**
     * @var list<SortBy>
     */
    private array $items = [];

    /**
     * @param list<SortBy> $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @return \Traversable<int, SortBy>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function add(SortBy $sortBy): void
    {
        $this->items[] = $sortBy;
    }

    public function toString(): string
    {
        return implode(',', array_map(static fn (SortBy $sortBy): string => $sortBy->toString(), $this->items));
    }
}
