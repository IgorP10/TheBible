<?php

namespace App\Bible\Http\Controller;

use App\Bible\Application\BookApplication;
use App\Bible\Application\DTO\BookDTO;
use App\Bible\Application\DTO\VersionDTO;
use App\Bible\Application\DTO\VersionFilterDTO;
use App\Bible\Application\VersionApplication;
use App\Bible\Domain\BibleService;
use Kernel\Routes\RouteAttribute;
use Kernel\Http\Response\Response;
use Kernel\Http\Request\Interfaces\RequestInterface;
use Kernel\Http\Response\Interfaces\ResponseInterface;

class BibleController
{
    public function __construct(
        private BibleService $bibleService,
        private BookApplication $bookApplication,
        private VersionApplication $versionApplication
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

    #[RouteAttribute('POST', '/save-books')]
    public function saveBooks(RequestInterface $request): ResponseInterface
    {
        $body = $request->getBody();

        $savedBooks = $this->bookApplication->saveBooks(
            new BookDTO($body['books'])
        );

        return Response::json(['books' => $savedBooks]);
    }

    #[RouteAttribute('GET', '/versions')]
    public function getVersions(): ResponseInterface
    {
        $versions = $this->versionApplication->getVersions();

        return Response::json(['versions' => $versions->jsonSerialize()]);
    }

    #[RouteAttribute('GET', '/version', ['id'])]
    public function getVersionById(RequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id');
        $version = $this->versionApplication->getVersionById($id);

        return Response::json(['version' => $version->jsonSerialize()]);
    }

    #[RouteAttribute('GET', '/version-by-params')]
    public function getVersionByParams(RequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $version = $this->versionApplication->getVersionByFilter(
            new VersionFilterDTO(
                id: $params['id'] ?? null,
                versionCode: $params['versionCode'] ?? null
            )
        );

        return Response::json(['version' => $version->jsonSerialize()]);
    }

    #[RouteAttribute('POST', '/save-versions')]
    public function saveVersions(RequestInterface $request): ResponseInterface
    {
        $body = $request->getBody();

        $savedVersions = $this->versionApplication->saveVersions(
            new VersionDTO($body['versions'])
        );

        return Response::json(['versions' => $savedVersions]);
    }
}
