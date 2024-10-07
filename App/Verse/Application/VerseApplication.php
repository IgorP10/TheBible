<?php

namespace App\Verse\Application;
use App\Verse\Domain\Collection\VerseCollection;
use App\Verse\Domain\Service\VerseService;

class VerseApplication
{
    public function __construct(private VerseService $verseService)
    {
    }

    public function getVerses(string $version, string $abbreviation, int $chapterNumber): array
    {
        return $this->verseService->getVerses($version, $abbreviation, $chapterNumber);
    }
}
