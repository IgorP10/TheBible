<?php

namespace App\Bible\Domain;

use App\Bible\Domain\Entity\Book;
use App\Bible\Domain\Collection\BookCollection;
use App\Bible\Infrastructure\Repository\BookRepository;

class BookService
{
    public function __construct(private BookRepository $bookRepository)
    {
    }

    public function getBooks(): BookCollection
    {
        return $this->bookRepository->getBooks();
    }

    public function getBookById(int $id): ?Book
    {
        return $this->bookRepository->getBookById($id);
    }

    public function saveBooks(BookCollection $bookCollection): array
    {
        $books = $bookCollection->all();
        $savedBooks = [];
        foreach ($books as $book) {
            if (!$book instanceof Book) {
                throw new \InvalidArgumentException('All items in the collection must be instances of Book.');
            }
            
            $savedBooks[] = $this->bookRepository->saveBook($book);
        }

        return $savedBooks;
    }
}
