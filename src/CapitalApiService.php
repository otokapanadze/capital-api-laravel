<?php

namespace OtoKapanadze\CapitalApi;

use OtoKapanadze\CapitalApi\Contracts\ApiClientInterface;
use phpseclib3\Crypt\PublicKeyLoader as PhpseclibPublicKeyLoader;
use phpseclib3\Crypt\RSA;

class CapitalApiService
{
    private $sessionExpiration;


    const API_BASE_URL = 'https://api-capital.backend-capital.com/api/v1/';
    const HEADER_SECURITY_TOKEN = 'X-SECURITY-TOKEN';
    const HEADER_CST = 'CST';


    protected $apiClient;

    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function authenticate(): void
    {
        $apiKey = config('capital-api.security_token');
        $login = config('capital-api.login');
        $password = config('capital-api.password');

        $response = $this->apiClient->post(self::API_BASE_URL . 'session', [
            'identifier' => $login,
            'password' => $password,
        ], [
            'X-CAP-API-KEY' => $apiKey,
        ]);

        $this->sessionExpiration = time() + 3600;

        config(['capital-api.cst' => $response['headers']['CST'], 'capital-api.security_token' => $response['headers']['X-SECURITY-TOKEN']]);
    }

    private function checkAndRefreshAuthentication(): void
    {
        if ($this->isAuthenticationExpired()) {
            $this->authenticate();
        }
    }

    private function isAuthenticationExpired(): bool
    {
        return !$this->sessionExpiration || time() >= $this->sessionExpiration;
    }

    public function serverTime(): array
    {
        $this->checkAndRefreshAuthentication();

        return $this->apiClient->get(self::API_BASE_URL . 'time', [])['body'] ?? [];
    }

    public function ping(): array
    {
        $this->checkAndRefreshAuthentication();

        $headers = [
            self::HEADER_SECURITY_TOKEN => config('capital-api.security_token'),
            self::HEADER_CST => config('capital-api.cst'),
            'Content-Type' => 'application/json',
        ];

        return $this->apiClient->get(self::API_BASE_URL . 'ping', [], $headers)['body'] ?? [];
    }

    public function getAllPositions(): array
    {
        $this->checkAndRefreshAuthentication();

        $headers = [
            self::HEADER_SECURITY_TOKEN => config('capital-api.security_token'),
            self::HEADER_CST => config('capital-api.cst'),
            'Content-Type' => 'application/json',
        ];

        return $this->apiClient->get(self::API_BASE_URL . 'positions', [], $headers)['body'] ?? ['positions' => []];
    }

    public function createPosition(
        string $epic,
        string $direction,
        int    $size,
        array  $options = []
    ): array
    {
        $this->checkAndRefreshAuthentication();

        $headers = [
            self::HEADER_SECURITY_TOKEN => config('capital-api.security_token'),
            self::HEADER_CST => config('capital-api.cst'),
            'Content-Type' => 'application/json',
        ];

        $data = array_merge([
            'epic' => $epic,
            'direction' => $direction,
            'size' => $size,
        ], $options);

        return $this->apiClient->post(self::API_BASE_URL . 'positions', $data, $headers)['body'] ?? [];
    }
}
