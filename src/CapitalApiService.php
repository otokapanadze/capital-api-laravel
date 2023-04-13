<?php

namespace OtoKapanadze\CapitalApi;

use OtoKapanadze\CapitalApi\Contracts\ApiClientInterface;

class CapitalApiService
{
    protected $apiClient;

    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function get(string $endpoint, array $queryParams = []): array
    {
        return $this->apiClient->get($endpoint, $queryParams);
    }

    public function post(string $endpoint, array $data): array
    {
        return $this->apiClient->post($endpoint, $data);
    }

    public function put(string $endpoint, array $data): array
    {
        return $this->apiClient->put($endpoint, $data);
    }

    public function delete(string $endpoint, array $data = []): array
    {
        return $this->apiClient->delete($endpoint, $data);
    }
}
