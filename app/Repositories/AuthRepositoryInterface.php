<?php
namespace App\Repositories;

interface AuthRepositoryInterface
{
    public function issueAccessToken(array $payload): array;
    public function refreshAccessToken(string $refreshToken, string $clientId, string $clientSecret): array;
}
