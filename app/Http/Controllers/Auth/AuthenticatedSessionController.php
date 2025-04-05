<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->authenticate();


        return response()->json([
            'message' => 'Login successful.',
            'token' => $request->user()->createToken('api')->plainTextToken,
            'user' => $request->user(),
        ], 200);

    }

    public function destroy(Request $request): Response
    {
        $user = $request->user();
        $user->tokens()->delete();

        // Return a 204 No Content response
        return response()->noContent();
    }


}
