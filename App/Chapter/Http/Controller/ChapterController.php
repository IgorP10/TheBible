<?php

namespace App\Chapter\Http\Controller;

use Kernel\Routes\RouteAttribute;
use Kernel\Http\Response\Response;
use App\Chapter\Application\ChapterApplication;
use Kernel\Http\Response\Interfaces\ResponseInterface;

class ChapterController
{
    public function __construct(private ChapterApplication $chapterApplication)
    {
    }

    #[RouteAttribute('GET', '/chapters')]
    public function getChapters(): ResponseInterface
    {
        $chapters = $this->chapterApplication->getChapters();

        return Response::json(['chapters' => $chapters]);
    }

    #[RouteAttribute('POST', '/save-chapters')]
    public function saveChapter(): ResponseInterface
    {
        $this->chapterApplication->saveChapters();

        return Response::json(['response' => 'capitulos salvos com sucesso!']);
    }
}
