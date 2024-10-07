<?php

namespace App\Verse\Domain\Service;
use App\Verse\Domain\Collection\VerseCollection;
use App\Verse\Domain\Entity\Verse;
use App\Verse\Infrastructure\Client\VerseClient;
use App\Verse\Infrastructure\Repository\VerseRepository;

class VerseService
{
    public function __construct(
        private VerseRepository $verseRepository,
        private VerseClient $verseClient
    ) {
    }

    public function getVerses(string $version, string $abbreviation, int $chapterNumber): array
    {
        return $this->verseClient->getVerses($version, $abbreviation, $chapterNumber);
    }

    public function saveVerses(VerseCollection $verseCollection): VerseCollection
    {
        $verses = $verseCollection->all();
        $savedVerses = new VerseCollection([]);
        foreach ($verses as $verse) {
            if (!$verse instanceof Verse) {
                throw new \InvalidArgumentException('Invalid version object');
            }

            $savedVerses->add(
                $this->verseRepository->saveVerse($verse)
            );
        }

        return $savedVerses;
    }
}
