<?php

namespace OtoKapanadze\CapitalApi\Contracts;

interface ApiClientInterface
{
    public function get(string $endpoint, array $queryParams = []): array;

    public function post(string $endpoint, array $data): array;

    public function put(string $endpoint, array $data): array;

    public function delete(string $endpoint, array $data = []): array;
}
