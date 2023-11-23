<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ValidateLoginRequest;
use App\Services\AuthenticationService;
class AuthenticationController extends Controller
{
    public function login(ValidateLoginRequest $request, AuthenticationService $authService)
    {
        return $authService->login($request->validated());
    }

    public function register(RegisterUserRequest $request, AuthenticationService $authService)
    {
        return $authService->store($request);
    }

}
