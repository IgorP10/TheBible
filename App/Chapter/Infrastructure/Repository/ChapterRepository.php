<?php

namespace App\Chapter\Infrastructure\Repository;

use Kernel\Db\BaseRepository;
use App\Bible\Domain\Entity\Book;
use App\Chapter\Domain\Entity\Chapter;
use Kernel\Utility\Collection;

class ChapterRepository extends BaseRepository
{
    public function getEntity(): string
    {
        return Chapter::class;
    }

    public function getChapters(): Collection
    {
        return new Collection(
            $this->findByFilters()
        );
    }

    public function getChapterByNumber(Book $book, int $chapterNumber): ?Chapter
    {
        return $this->findOneBy([
            'book' => $book,
            'chapterNumber' => $chapterNumber
        ]);
    }

    public function saveMultiples(Collection $chapters): void
    {
        $this->transactional(
            function (self $repository) use ($chapters) {
                foreach ($chapters as $chapter) {
                    $repository->persist($chapter);
                }
                $repository->flush();
                $repository->clear();
            }
        );
    }
}
