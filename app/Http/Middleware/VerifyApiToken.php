<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\RedirectResponse;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse|RedirectResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse|RedirectResponse
    {
        $token = $request->query('api_token');
        if (!$token) {
            return ApiResponse::error('API token not provided', 401);
        }

        $apiToken = ApiToken::query()->where('token', $token)->first();

        if (!$apiToken) {
            return ApiResponse::error('Invalid API token', 401);
        }
        return $next($request);
    }
}
