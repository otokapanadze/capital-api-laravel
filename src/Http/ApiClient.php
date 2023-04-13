<?php

namespace OtoKapanadze\CapitalApi\Http;

use OtoKapanadze\CapitalApi\Contracts\ApiClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiClient implements ApiClientInterface
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function get(string $endpoint, array $queryParams = []): array
    {
        try {
            $response = $this->httpClient->get($endpoint, [
                'query' => $queryParams,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Error executing GET request: ' . $e->getMessage());
        }
    }

    public function post(string $endpoint, array $data, array $headers = []): array
    {
        try {
            $response = $this->httpClient->post($endpoint, [
                'json' => $data,
                'headers' => $headers,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Error executing POST request: ' . $e->getMessage());
        }
    }

    public function put(string $endpoint, array $data, array $headers = []): array
    {
        try {
            $response = $this->httpClient->put($endpoint, [
                'json' => $data,
                'headers' => $headers,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Error executing PUT request: ' . $e->getMessage());
        }
    }

    public function delete(string $endpoint, array $data = [], array $headers = []): array
    {
        try {
            $response = $this->httpClient->delete($endpoint, [
                'json' => $data,
                'headers' => $headers,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Error executing DELETE request: ' . $e->getMessage());
        }
    }
}
