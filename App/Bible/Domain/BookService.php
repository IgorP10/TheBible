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
        try {
            if ($books = getCache('bookCollection')) {
                return $books;
            }

            $books = $this->bookRepository->getBooks();

            setCache('bookCollection', $books, 3600);

            return $books;
        } catch (\Exception $e) {
            throw new \Exception('Error getting books');
        }
    }

    public function getBookById(int $id): ?Book
    {
        try {
            if ($book = getCache('book_' . $id)) {
                return $book;
            }

            $book = $this->bookRepository->getBookById($id);

            setCache('book_' . $id, $book, 3600);

            return $book;
        } catch (\Exception $e) {
            throw new \Exception('Error getting book');
        }
    }

    public function getBookByName(string $name): ?Book
    {
        try {
            if ($book = getCache('book_' . $name)) {
                return $book;
            }

            $book = $this->bookRepository->getBookByName($name);

            setCache('book_' . $name, $book, 3600);

            return $book;
        } catch (\Exception $e) {
            throw new \Exception('Error getting book');
        }
    }

    public function saveBooks(BookCollection $bookCollection): BookCollection
    {
        $books = $bookCollection->all();
        $savedBooks = new BookCollection([]);
        foreach ($books as $book) {
            if (!$book instanceof Book) {
                throw new \InvalidArgumentException('All items in the collection must be instances of Book.');
            }

            if (!empty($this->getBookByName($book->getName()))) {
                $savedBooks->add($book);
                continue;
            }

            $savedBooks->add($this->bookRepository->saveBook($book));
        }

        return $savedBooks;
    }
}
