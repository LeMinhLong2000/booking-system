<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return $this->success([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'Register successfully.', 201);
    }


    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        return $this->success([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'Login successfully.');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->success(
            null,
            'Logout successfully.'
        );
    }

    public function me(Request $request)
    {
        return $this->success(
            new UserResource(
                $this->authService->me($request->user())
            ),
            'User profile retrieved successfully.'
        );
    }
}
