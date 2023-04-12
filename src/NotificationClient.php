<?php

namespace NotificationClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class NotificationClient
{
    private Client $client;

    public function __construct(
        private string $clientId,
        private string $token,
        private string $url,
        private bool $httpErrors = false
    )
    {
        $this->client = new Client([
            'http_errors' => $this->httpErrors,
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function emit(string $name, array $payload): bool
    {
        $response = $this->client->post($this->url, ['json' => [
            'name' => $name,
            'payload' => $payload,
            'clientId' => $this->clientId,
            'token' => $this->token
        ]]);

        if($response->getStatusCode() != 200){
            return false;
        }
        return true;
    }
}
