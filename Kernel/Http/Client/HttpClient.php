<?php

namespace Kernel\Http\Client;

class HttpClient
{
    public function __construct(private string $baseUrl)
    {
    }

    public function get(string $uri, array $headers = []): array
    {
        return $this->request('GET', $uri, null, $headers);
    }

    public function post(string $uri, array $body, array $headers = []): array
    {
        return $this->request('POST', $uri, $body, $headers);
    }

    public function put(string $uri, array $body, array $headers = []): array
    {
        return $this->request('PUT', $uri, $body, $headers);
    }

    public function delete(string $uri, array $headers = []): array
    {
        return $this->request('DELETE', $uri, null, $headers);
    }

    private function request(string $method, string $uri, ?array $body = null, array $headers = []): array
    {
        $url = $this->baseUrl . $uri;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $formattedHeaders = [];
        foreach ($headers as $key => $value) {
            $formattedHeaders[] = "$key: $value";
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $formattedHeaders);

        if ($body !== null) {
            $jsonBody = json_encode($body);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
            error_log("JSON Body: " . $jsonBody);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        curl_close($ch);

        return ['status' => $httpCode, 'body' => $body];
    }
}
