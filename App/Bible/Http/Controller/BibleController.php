<?php

namespace App\Bible\Http\Controller;

use App\Bible\Domain\BibleService;
use Kernel\Routes\RouteAttribute;
use Kernel\Http\Response\Response;
use Kernel\Http\Request\Interfaces\RequestInterface;
use Kernel\Http\Response\Interfaces\ResponseInterface;

class BibleController
{
    public function __construct(private BibleService $bibleService)
    {
    }

    #[RouteAttribute('GET', '/books')]
    public function getBooks(RequestInterface $request): ResponseInterface
    {
        $books = $this->bibleService->getBooks();

        return Response::json(['data' => $books]);
    }
}
