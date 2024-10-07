<?php

namespace App\Chapter\Application;

use App\Bible\Application\BookApplication;
use App\Chapter\Domain\Service\ChapterService;
use Kernel\Utility\Collection;

class ChapterApplication
{
    public function __construct(
        private BookApplication $bookApplication,
        private ChapterService $chapterService,
    ) {
    }

    public function getChapters(): Collection
    {
        return $this->chapterService->getChapters();
    }

    public function saveChapters(): void
    {
        $books = $this->bookApplication->getBooks();
        $this->chapterService->saveChapters($books);
    }
}
