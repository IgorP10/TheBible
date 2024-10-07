<?php

namespace App\Chapter\Domain\Entity;

use App\Bible\Domain\Entity\Book;
use Doctrine\ORM\Mapping as ORM;
use Kernel\Utility\Entity;

/**
 * @method ?int getId()
 * @method Book getBook()
 * @method int getChapterNumber()
 * @SuppressWarnings("php:S1068")
 */

#[ORM\Entity]
#[ORM\Table(name: "chapters")]
class Chapter extends Entity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Book::class, fetch: "EAGER")]
    #[ORM\JoinColumn(name: "book_id", referencedColumnName: "id", nullable: false, onDelete: "cascade")]
    private Book $book;

    #[ORM\Column(name: "chapter_number", type: "integer", nullable: false)]
    private int $chapterNumber;
}
