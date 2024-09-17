<?php

namespace Kernel\Utility;

use ArrayIterator;

class Collection implements \JsonSerializable, \Countable, \IteratorAggregate
{
    public function __construct(private array $items)
    {
    }

    public function add(object $item): void
    {
        $this->items[] = $item;
    }

    public function remove(object $item): void
    {
        $key = array_search($item, $this->items, true);

        if ($key === false) {
            return;
        }

        unset($this->items[$key]);
    }

    public function get(int $key): ?object
    {
        return $this->items[$key] ?? null;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function jsonSerialize(): array
    {
        return array_map(fn($item) => $item->jsonSerialize(), $this->items);
    }
}
