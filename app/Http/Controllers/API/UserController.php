<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Jobs\SendVerificationEmailJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class UserController extends BaseController
{
    #[OA\Post(
        path: '/api/signup',
        summary: 'Sign Up',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['name', 'email', 'password'],
                    properties: [
                        new OA\Property(property: 'name', type: 'string'),
                        new OA\Property(property: 'email', type: 'string'),
                        new OA\Property(property: 'password', type: 'string'),
                    ]
                ),
            ),
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'data', properties: []),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
            new OA\Response(
                response: 401,
                description: 'Unauthorised',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )
            ),
        ]
    )]
    public function postSignUp(SignUpRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        SendVerificationEmailJob::dispatch($user)->onQueue('default');
        Auth::login($user);
        $result['token'] = $user->createToken('MyApp')->accessToken;
        $result['name'] = $user->name;

        return $this->sendResponse($result, 'User register successfully.');
    }

    #[OA\Post(
        path: '/api/signin',
        summary: 'Sign in',
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    required: ['email', 'password'],
                    properties: [
                        new OA\Property(property: 'email', type: 'string'),
                        new OA\Property(property: 'password', type: 'string'),
                    ]
                ),
            ),
        ),
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'data', properties: []),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
            new OA\Response(
                response: 401,
                description: 'Unauthorised',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'bool'),
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
        ]
    )]
    public function postSignIn(SignInRequest $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $result['token'] = $user->createToken('MyApp')-> accessToken;
            $result['name'] = $user->name;

            return $this->sendResponse($result, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Wrong email or password'], 401);
        }
    }

    #[OA\Post(
        path: '/api/logout',
        summary: 'Logout',
        security: [
            ['bearerAuth' => []],
        ],
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string'),
                    ],
                )),
        ]
    )]
    public function logout(): JsonResponse
    {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
