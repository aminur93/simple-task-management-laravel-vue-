<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwthAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Try to authenticate the user with the token
            JWTAuth::parseToken()->authenticate();

        } catch (TokenExpiredException $exception) {
            // Token is expired, so refresh the token and return it
            try {
                $newToken = JWTAuth::parseToken()->refresh();
                return response()->json(['success' => false, 'token' => $newToken, 'status' => 'expired'], 200);
            } catch (\Exception $e) {
                // Failed to refresh, token might be completely invalid
                return response()->json(['success' => false, 'message' => 'Token refresh failed, please login again'], 401);
            }
        } catch (TokenInvalidException $exception) {
            // Token is invalid
            return response()->json(['success' => false, 'message' => 'Token Invalid'], 401);
        } catch (\Exception $exception) {
            // Any other error (token not found or other issues)
            return response()->json(['success' => false, 'message' => 'Token not found or invalid'], 401);
        }

        return $next($request);
    }
}