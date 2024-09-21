<?php

namespace App\Bible\Application\DTO;
use App\Bible\Domain\Entity\Version;
use App\Bible\Domain\Collection\VersionCollection;

class VersionDTO
{
    public function __construct(
        private array $books
    ) {
    }

    public function getVersionCollection(): VersionCollection
    {
        $items = [];
        foreach ($this->books as $book) {
            $items[] = new Version(
                $book['versionCode'],
                $book['description']
            );
        }

        return new VersionCollection($items);
    }
}
