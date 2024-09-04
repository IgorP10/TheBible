<?php

namespace Kernel\Utility;

class Collection
{
    public function __construct(private array $items)
    {
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function jsonSerialize(): array
    {
        return array_map(fn($item) => $item->jsonSerialize(), $this->items);
    }
}
