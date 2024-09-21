<?php

namespace App\Bible\Infrastructure\Client;

use App\Bible\Domain\Collection\VersionCollection;
use Kernel\Http\Client\HttpClient;

class VersionClient
{
    const A_BIBLIA_DIGITAL_GET_VERSIONS = '/api/versions';
    private HttpClient $httpClient;

    public function __construct()
    {
        $this->httpClient = new HttpClient(env('A_BIBLIA_DIGITAL_URL'));
    }

    public function getVersions(): array
    {
        $response = $this->httpClient->get(self::A_BIBLIA_DIGITAL_GET_VERSIONS);

        if ($response['status'] !== 200) {
            throw new \Exception('Error getting versions');
        }

        $response = json_decode($response['body'], true);

        return $response;
    }
}
