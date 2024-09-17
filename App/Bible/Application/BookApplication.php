<?php

namespace App\Bible\Application;

use App\Bible\Domain\BookService;
use App\Bible\Application\DTO\BookDTO;

class BookApplication
{
    public function __construct(
        private BookService $bookService
    )
    {
    }

    public function saveBooks(BookDTO $bookDTO): array
    {
        return $this->bookService->saveBooks($bookDTO->getBookCollection());
    }
}
