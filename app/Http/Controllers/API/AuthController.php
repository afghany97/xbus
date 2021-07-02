<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Utils\HttpStatusCodeUtil;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $this->validateLoginRequest($request);
            if (!$token = Auth::attempt($credentials)) {
                $payload = [
                    "errors" => [
                        "message" => 'Sorry, wrong email address or password. Please try again',
                    ]
                ];
                return $this->response($payload, 401);
            }
            return $this->response($this->getSuccessfulLoginPayload($token), HttpStatusCodeUtil::OK);
        } catch (ValidationException $exception) {
            $payload = [
                "errors" => [
                    "message" => $exception->getMessage()
                ]
            ];
            return $this->response($payload, HttpStatusCodeUtil::UNPROCESSABLE_ENTITY);
        } catch (JWTException | Exception  $exception) {
            Log::error($exception->getMessage(), compact("exception"));
            $payload = [
                "errors" => [
                    "message" => $exception->getMessage()
                ]
            ];
            return $this->response($payload, HttpStatusCodeUtil::INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            Auth::logout();
            return $this->response([], HttpStatusCodeUtil::OK);
        } catch (JWTException | Exception  $exception) {
            Log::error($exception->getMessage(), compact("exception"));
            $payload = [
                "errors" => [
                    "message" => $exception->getMessage()
                ]
            ];
            return $this->response($payload, HttpStatusCodeUtil::INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateLoginRequest(Request $request): array
    {
        return $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);
    }

    /**
     * @param string $token
     * @return array
     */
    private function getSuccessfulLoginPayload(string $token): array
    {
        return [
            "user" => UserResource::make(auth()->user()),
            "token" => $token
        ];
    }
}
