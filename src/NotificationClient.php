<?php

namespace NotificationClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class NotificationClient
{
    public function __construct(
        private string $clientId,
        private string $token,
        private string $url,
        private bool $httpErrors = false
    )
    {}

    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function emit(string $name, array $payload): bool
    {
        $client = new Client([
            'http_errors' => $this->httpErrors,
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest'
            ]
        ]);
        try {
            $client->post($this->url, ['json' => [
                'name' => $name,
                'payload' => $payload,
                'clientId' => $this->clientId,
                'token' => $this->token
            ]]);
        } catch (ClientException $e) {
            if($e->getCode() == 422){
                $exception = json_decode($e->getResponse()->getBody());
                throw new \Exception(json_encode($exception->errors));
            }
            throw $e;
        }
        return true;
    }
}
