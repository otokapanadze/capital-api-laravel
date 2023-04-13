<?php

namespace OtoKapanadze\CapitalApi;

use OtoKapanadze\CapitalApi\Contracts\ApiClientInterface;
use phpseclib3\Crypt\PublicKeyLoader as PhpseclibPublicKeyLoader;
use phpseclib3\Crypt\RSA;

class CapitalApiService
{
    const API_BASE_URL = 'https://api-capital.backend-capital.com/api/v1/';
    const HEADER_SECURITY_TOKEN = 'X-SECURITY-TOKEN';
    const HEADER_CST = 'CST';


    protected $apiClient;

    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function authenticate(string $apiKey, string $login, string $password, bool $encryptPassword = false): array
    {
        if ($encryptPassword) {
            $encryptionResponse = $this->apiClient->get('/session/encryptionKey', [
                'X-CAP-API-KEY' => $apiKey,
            ]);

            $encryptedPassword = $this->encryptPassword(
                $encryptionResponse['encryptionKey'],
                $encryptionResponse['timestamp'],
                $password
            );

            $password = $encryptedPassword;
        }

        $response = $this->apiClient->post('/session', [
            'identifier' => $login,
            'password' => $password,
            'encryptedPassword' => $encryptPassword,
        ], [
            'X-CAP-API-KEY' => $apiKey,
        ]);

        return [
            'CST' => $response['headers']['CST'],
            'X-SECURITY-TOKEN' => $response['headers']['X-SECURITY-TOKEN'],
        ];
    }

    private function encryptPassword(string $encryptionKey, int $timestamp, string $password): string
    {
        $rsa = PhpseclibPublicKeyLoader::load($encryptionKey);
        $rsa = $rsa->withPadding(RSA::ENCRYPTION_PKCS1);

        $data = $password . '|' . $timestamp;
        $data = base64_encode($data);

        $encryptedPassword = $rsa->encrypt($data);
        return base64_encode($encryptedPassword);
    }
}
