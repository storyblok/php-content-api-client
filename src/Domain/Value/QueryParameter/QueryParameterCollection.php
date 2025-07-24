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

namespace Storyblok\Api\Domain\Value\QueryParameter;

/**
 * @author Frank Stelzer <dev@frankstelzer.de>
 * @author Silas Joisten <silasjoisten@proton.me>
 *
 * @implements \IteratorAggregate<int, QueryParameter>
 */
final class QueryParameterCollection implements \Countable, \IteratorAggregate
{
    /**
     * @var QueryParameter[]
     */
    private array $items = [];

    /**
     * @param QueryParameter[] $items
     */
    public function __construct(
        array $items = [],
    ) {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * @return \Traversable<int, QueryParameter>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function add(QueryParameter $queryParameter): void
    {
        if ($this->has($queryParameter)) {
            return;
        }

        $this->items[] = $queryParameter;
    }

    public function has(QueryParameter $queryParameter): bool
    {
        foreach ($this->items as $item) {
            if ($item->name === $queryParameter->name) {
                return true;
            }
        }

        return false;
    }

    public function remove(QueryParameter $queryParameter): void
    {
        foreach ($this->items as $key => $item) {
            if ($item->name === $queryParameter->name) {
                unset($this->items[$key]);

                break;
            }
        }
    }

    /**
     * @return array{
     *     published_at_gt?: string,
     *     published_at_lt?: string,
     *     first_published_at_gt?: string,
     *     first_published_at_lt?: string,
     *     updated_at_gt?: string,
     *     updated_at_lt?: string,
     * }
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->items as $queryParameter) {
            $result[$queryParameter->name] = $queryParameter->value;
        }

        return $result;
    }
}
