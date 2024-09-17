<?php

namespace App\Bible\Infrastructure\Repository;

use App\Bible\Domain\Collection\BookCollection;
use App\Bible\Domain\Entity\Book;
use Kernel\Db\BaseRepository;

class BookRepository extends BaseRepository
{
    public function getEntity(): string
    {
        return Book::class;
    }

    public function getBooks(): BookCollection
    {
        return new BookCollection(
            $this->findAll()
        );
    }

    public function getBookById(int $id): ?Book
    {
        return $this->findById($id);
    }

    public function saveBook(Book $book): Book
    {
        $this->persist($book);

        return $book;
    }
}
