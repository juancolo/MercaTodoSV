<?php

namespace App\Http\Controllers\Api;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!is_null($user) && Hash::check($request->password, $user->password)) {

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'accesses_token' => $token,
                'token_type' => trans('api.toke.type')
            ]);
        } else {
            return response()->json([
                'status_code' => 403,
                'message' => trans('api.login.auth_failed')
            ]);
        }
    }
}
