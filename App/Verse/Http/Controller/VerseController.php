<?php

namespace App\Verse\Http\Controller;

use Kernel\Http\Request\Request;
use Kernel\Http\Response\Response;
use App\Verse\Application\VerseApplication;
use Kernel\Http\Response\Interfaces\ResponseInterface;
use Kernel\Routes\RouteAttribute;

class VerseController
{
    public function __construct(
        private VerseApplication $verseApplication
    ) {
    }

    #[RouteAttribute(
        'GET',
        '/verses',
        ['version', 'abbreviation', 'chapter'])
    ]
    public function getVerses(Request $request): ResponseInterface
    {
        $version = $request->getAttribute('version');
        $abbreviation = $request->getAttribute('abbreviation');
        $chapter = $request->getAttribute('chapter');

        $verses = $this->verseApplication->getVerses(
            $version,
            $abbreviation,
            $chapter
        );

        return Response::json(['verses' => $verses]);
    }
}
