<?php

namespace OtoKapanadze\CapitalApi\Http;

use OtoKapanadze\CapitalApi\Contracts\ApiClientInterface;

class ApiClient implements ApiClientInterface
{

    public function get(string $endpoint, array $queryParams = []): array
    {
        // TODO: Implement get() method.
    }

    public function post(string $endpoint, array $data): array
    {
        // TODO: Implement post() method.
    }

    public function put(string $endpoint, array $data): array
    {
        // TODO: Implement put() method.
    }

    public function delete(string $endpoint, array $data = []): array
    {
        // TODO: Implement delete() method.
    }
}
