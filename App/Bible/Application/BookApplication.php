<?php

namespace App\Bible\Application;

use App\Bible\Domain\BookService;
use App\Bible\Domain\Entity\Book;
use App\Bible\Application\DTO\BookDTO;
use App\Bible\Domain\Collection\BookCollection;

class BookApplication
{
    public function __construct(
        private BookService $bookService
    ) {
    }

    public function getBooks(): BookCollection
    {
        return $this->bookService->getBooks();
    }

    public function getBookById(int $id): ?Book
    {
        return $this->bookService->getBookById($id);
    }

    public function saveBooks(BookDTO $bookDTO): BookCollection
    {
        return $this->bookService->saveBooks($bookDTO->getBookCollection());
    }
}
