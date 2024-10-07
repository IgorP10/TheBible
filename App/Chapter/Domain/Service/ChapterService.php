<?php

namespace App\Chapter\Domain\Service;

use App\Bible\Domain\Collection\BookCollection;
use App\Bible\Domain\Entity\Book;
use App\Chapter\Infrastructure\Repository\ChapterRepository;
use Kernel\Utility\Collection;

class ChapterService
{
    public function __construct(
        private ChapterRepository $chapterRepository
    ) {
    }

    public function getChapters(): Collection
    {
        return $this->chapterRepository->getChapters();
    }

    public function saveChapters(BookCollection $bookCollection): void
    {
        $entities = [];
        foreach ($bookCollection as $book) {
            for ($i = 1; $i <= $book->getTotalChapters(); $i++) {
                if (!is_null($this->chapterRepository->getChapterByNumber($book, $i))) {
                    continue;
                }
                $chapter = $this->chapterRepository->createEntity();
                $chapter->setBook($this->chapterRepository->getReference(Book::class, $book->getId()));
                $chapter->setChapterNumber($i);
                $entities[] = $chapter;
            }
        }

        $this->chapterRepository->saveMultiples(new Collection($entities));
    }
}
