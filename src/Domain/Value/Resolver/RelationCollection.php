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

namespace Storyblok\Api\Domain\Value\Resolver;

/**
 * @author Silas Joisten <silasjoisten@proton.me>
 *
 * @implements \IteratorAggregate<int, Relation>
 */
final class RelationCollection implements \Countable, \IteratorAggregate
{
    /**
     * @var list<Relation>
     */
    private array $items = [];

    /**
     * @param list<Relation|string> $items
     */
    public function __construct(
        array $items = [],
    ) {
        foreach ($items as $item) {
            if (\is_string($item)) {
                $item = new Relation($item);
            }

            $this->add($item);
        }
    }

    /**
     * @return \Traversable<int, Relation>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function add(Relation $relation): void
    {
        if ($this->has($relation)) {
            return;
        }

        $this->items[] = $relation;
    }

    public function has(Relation $relation): bool
    {
        foreach ($this->items as $item) {
            if ($item->value === $relation->value) {
                return true;
            }
        }

        return false;
    }

    public function remove(Relation $relation): void
    {
        foreach ($this->items as $key => $item) {
            if ($item->value === $relation->value) {
                unset($this->items[$key]);

                break;
            }
        }
    }

    public function toString(): string
    {
        return implode(',', array_map(static fn (Relation $relation): string => $relation->value, $this->items));
    }

    public static function fromString(string $data): self
    {
        if ('' === $data) {
            return new self();
        }

        return new self(\array_map(static fn (string $value): Relation => new Relation($value), \explode(',', $data)));
    }
}
