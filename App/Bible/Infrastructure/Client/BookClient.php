<?php

namespace App\Bible\Infrastructure\Client;

use Kernel\Http\Client\HttpClient;

class BookClient
{
    const A_BIBLIA_DIGITAL_GET_BOOKS = '/api/books';
    private HttpClient $httpClient;

    public function __construct()
    {
        $this->httpClient = new HttpClient(env('A_BIBLIA_DIGITAL_URL'));
    }

    public function getBooks(): array
    {
        $response = $this->httpClient->get(self::A_BIBLIA_DIGITAL_GET_BOOKS);

        if ($response['status'] !== 200) {
            throw new \Exception('Error getting books');
        }

        $response = json_decode($response['body'], true);

        return $response;
    }

    public function getBook(string $abbreviation): array
    {
        $response = $this->httpClient->get(self::A_BIBLIA_DIGITAL_GET_BOOKS . "/$abbreviation");

        if ($response['status'] !== 200) {
            throw new \Exception('Error getting book');
        }

        $response = json_decode($response['body'], true);

        return $response;
    }
}
