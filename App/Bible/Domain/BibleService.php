<?php

namespace App\Bible\Domain;

use App\Bible\Infrastructure\Client\BookClient;

class BibleService
{
    public function __construct(private BookClient $bookClient)
    {
    }

    public function getBooks(): array
    {
        return $this->bookClient->getBooks();
    }

    public function getBook(string $abbreviation): array
    {
        return $this->bookClient->getBook($abbreviation);
    }
}
