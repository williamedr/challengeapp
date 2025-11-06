<?php
namespace App\Repositories;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class PassportAuthRepository implements AuthRepositoryInterface
{
    protected string $tokenUrl;

    public function __construct()
    {
        $this->tokenUrl = config('app.url') . '/oauth/token';
    }

    public function issueAccessToken(array $payload): array
    {
        // payload must contain grant_type, client_id, client_secret, username, password, scope
        $response = Http::acceptJson()->post($this->tokenUrl, $payload);

        return $response->json();
    }

    public function refreshAccessToken(string $refreshToken, string $clientId, string $clientSecret): array
    {
        $payload = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => '',
        ];

        $response = Http::asForm()->post($this->tokenUrl, $payload);

        return $response->json();
    }
}
