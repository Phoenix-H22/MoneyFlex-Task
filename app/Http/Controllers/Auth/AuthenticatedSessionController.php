<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Customer API Documentation",
 *      description="API Docs for managing customers",
 *      @OA\Contact(
 *          email="support@example.com"
 *      )
 * )
 */

class AuthenticatedSessionController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Login a user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login successful."),
     *             @OA\Property(property="token", type="string", example="your-generated-jwt-token"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
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
    /**
     * @OA\Delete(
     *     path="/api/logout",
     *     tags={"Auth"},
     *     summary="Logout a user",
     *     security={{"Bearer": {}}},
     *     @OA\Response(response=204, description="Logout successful"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function destroy(Request $request): Response
    {
        $user = $request->user();
        $user->tokens()->delete();

        // Return a 204 No Content response
        return response()->noContent();
    }


}
