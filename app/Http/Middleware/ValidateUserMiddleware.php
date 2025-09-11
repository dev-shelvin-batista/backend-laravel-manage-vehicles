<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class ValidateUserMiddleware
{
    /**
     * Middleware to validate whether the user making a request to a REST API has a session in the frontend application using a JWT token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Attempt to parse and validate the token
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'Token Expired'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'Token Invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'Token not provided'], 401);
        }

        // Validate whether the user exists and is authorized.
        if (!$user) {
            return response()->json(['status' => 'Unauthorized'], 401);
        }
        
        return $next($request);
    }
}
