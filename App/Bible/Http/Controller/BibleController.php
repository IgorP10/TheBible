<?php

namespace App\Bible\Http\Controller;

use App\Bible\Application\BookApplication;
use App\Bible\Application\DTO\BookDTO;
use App\Bible\Domain\BibleService;
use Kernel\Routes\RouteAttribute;
use Kernel\Http\Response\Response;
use Kernel\Http\Request\Interfaces\RequestInterface;
use Kernel\Http\Response\Interfaces\ResponseInterface;

class BibleController
{
    public function __construct(
        private BibleService $bibleService,
        private BookApplication $bookApplication
    ) {
    }

    #[RouteAttribute('GET', '/books')]
    public function getBooks(): ResponseInterface
    {
        $books = $this->bookApplication->getBooks();

        return Response::json(['books' => $books->jsonSerialize()]);
    }

    #[RouteAttribute('GET', '/book', ['id'])]
    public function getBookByAbbreviation(RequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $book = $this->bookApplication->getBookById($id);

        return Response::json(['book' => $book->jsonSerialize()]);
    }

    #[RouteAttribute('GET', '/versions')]
    public function getVersions(): ResponseInterface
    {
        $versions = $this->bibleService->getVersions();

        return Response::json(['data' => $versions]);
    }

    #[RouteAttribute('POST', '/save-books')]
    public function saveBooks(RequestInterface $request): ResponseInterface
    {
        $books = $request->getBody();

        $savedBooks = $this->bookApplication->saveBooks(
            new BookDTO($books['books'])
        );

        return Response::json(['data' => $savedBooks]);
    }
}
