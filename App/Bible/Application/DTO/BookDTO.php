<?php

namespace App\Bible\Application\DTO;

use App\Bible\Domain\Entity\Book;
use App\Bible\Domain\Collection\BookCollection;

class BookDTO
{
    public function __construct(
        private array $books
    ) {
    }

    public function getBookCollection(): BookCollection
    {
        $items = [];
        foreach ($this->books as $book) {
            $items[] = new Book(
                $book['abbreviation'],
                $book['author'],
                $book['chapters'],
                $book['group'],
                $book['name'],
                $book['testament']
            );
        }

        return new BookCollection($items);
    }
}
