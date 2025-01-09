<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @tags Auth
 */
class AuthenticatedUserController extends Controller
{
    /**
     * Get authenticated user profile data.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(['user' => $request->user()]);
    }
}
