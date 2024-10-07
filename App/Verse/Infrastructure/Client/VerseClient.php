<?php

namespace App\Verse\Infrastructure\Client;

use Kernel\Http\Client\HttpClient;

class VerseClient
{
    const GET_VERSES = '/api/verses/%s/%s/%s';
    private HttpClient $httpClient;

    public function __construct()
    {
        $this->httpClient = new HttpClient(env('A_BIBLIA_DIGITAL_URL'));
    }

    public function getVerses(string $version, string $abbreviation, int $chapterNumber): array
    {
        $url = sprintf(self::GET_VERSES, $version, $abbreviation, $chapterNumber);
        $response = $this->httpClient->get($url);

        if ($response['status'] !== 200) {
            throw new \Exception('Error getting book');
        }

        $response = json_decode($response['body'], true);

        return $response;
    }
}
