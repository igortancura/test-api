<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Api\ValidationApiException;
use App\Http\Resources\Api\Auth\TokenResource;
use App\Http\Resources\Api\Message\ValidMessageResource;
use OpenApi\Attributes as OA;


class AuthController extends Controller
{
    #[OA\Post(
        path: '/api/v1/register',
        description: 'Register',
        summary: 'Register a new user',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/RegisterRequest',
            )
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Success',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/TokenResource',
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Failure',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/InvalidMessageResource',
                )
            ),
        ]
    )]
    public function register(RegisterRequest $request): TokenResource
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        return new TokenResource(User::create($data));
    }

    #[OA\Post(
        path: '/api/v1/login',
        description: 'Login',
        summary: 'login user',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/LoginRequest',
            )
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Success',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/TokenResource',
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Failure',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/InvalidMessageResource',
                )
            ),
        ]
    )]
    public function login(LoginRequest $request): TokenResource
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationApiException::withMessages([
                'password' => ['The provided credentials are incorrect.'],
            ]);
        }
        return new TokenResource($user);
    }

    #[OA\Get(
        path: '/api/v1/logout',
        description: 'logout',
        summary: 'logout user',
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Success',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidMessageResource',
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Failure',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/InvalidMessageResource',
                )
            ),
        ]
    )]
    public function logout(Request $request): ValidMessageResource
    {
        $request->user()->currentAccessToken()->delete();
        return new ValidMessageResource(
            [
                'messages' => ['Logged out successfully'],
            ],
            200
        );
    }
}
