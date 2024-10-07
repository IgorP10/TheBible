<?php

namespace App\Verse\Infrastructure\Repository;
use App\Verse\Domain\Collection\VerseCollection;
use App\Verse\Domain\Entity\Verse;
use Kernel\Db\BaseRepository;

class VerseRepository extends BaseRepository
{
    public function getEntity(): string
    {
        return Verse::class;
    }

    public function getVersesByChapterId(int $chapterId): VerseCollection
    {
        return new VerseCollection(
            $this->findByFilters([
                'chapter_id' => $chapterId
            ])
        );
    }

    public function saveVerse(Verse $verse): Verse
    {
        $this->persist($verse);
        $this->flush();

        return $verse;
    }
}
