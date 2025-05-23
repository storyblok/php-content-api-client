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

namespace Storyblok\Api\Domain\Value;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 *
 * @implements \IteratorAggregate<int, Id>
 */
final class IdCollection implements \Countable, \IteratorAggregate
{
    /**
     * @var list<Id>
     */
    private array $items = [];

    /**
     * @param list<Id|int> $items
     */
    public function __construct(
        array $items = [],
    ) {
        foreach ($items as $item) {
            if (\is_int($item)) {
                $item = new Id($item);
            }

            $this->add($item);
        }
    }

    /**
     * @return \Traversable<int, Id>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function add(Id $id): void
    {
        if ($this->has($id)) {
            return;
        }

        $this->items[] = $id;
    }

    public function has(Id $id): bool
    {
        foreach ($this->items as $item) {
            if ($item->value === $id->value) {
                return true;
            }
        }

        return false;
    }

    public function remove(Id $id): void
    {
        foreach ($this->items as $key => $item) {
            if ($item->value === $id->value) {
                unset($this->items[$key]);

                break;
            }
        }
    }

    public function toString(): string
    {
        return implode(',', array_map(static fn (Id $id): string => (string) $id->value, $this->items));
    }
}
