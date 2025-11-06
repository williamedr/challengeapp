<?php
namespace App\Services;

use App\Repositories\AuthRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    protected AuthRepositoryInterface $authRepo;
    protected UserRepositoryInterface $userRepo;
    protected string $clientId;
    protected string $clientSecret;

    public function __construct(AuthRepositoryInterface $authRepo, UserRepositoryInterface $userRepo) {
        $this->authRepo = $authRepo;
        $this->userRepo = $userRepo;
        $this->clientId = config('services.passport.client_id');         // set in env
        $this->clientSecret = config('services.passport.client_secret'); // set in env
    }

    public function login(array $data): array
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ['error' => true, 'messages' => $validator->errors()];
        }

        $user = $this->userRepo->findByEmail($data['email']);
        if (!$user) {
            return ['error' => true, 'message' => 'Credenciales inválidas'];
        }

        $payload = [
            'grant_type' => 'password',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $data['email'],
            'password' => $data['password'],
            'scope' => '',
        ];

        return $this->authRepo->issueAccessToken($payload);
    }

    public function refreshToken(string $refreshToken): array
    {
        return $this->authRepo->refreshAccessToken($refreshToken, $this->clientId, $this->clientSecret);
    }


    public function signup(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ['error' => true, 'messages' => $validator->errors()];
        }

        $user = $this->userRepo->findByEmail($data['email']);
        if ($user) {
            return ['error' => true, 'message' => 'User already exists.'];
        }

        return $this->userRepo->create($data)->toArray();
    }

}
