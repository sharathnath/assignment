<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use App\Models\Admin;
use App\Models\User;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use App\Models\Constant;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('Authorization');
        if (!empty($token)) {
            try {
                $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);

                if ($credentials->userRole == Constant::USER_TYPE_ADMIN) {
                    $user = Admin::find($credentials->userId);
                    $user['userRole'] = Constant::USER_TYPE_ADMIN;
                } 
                // Now let's put the user in the request class so that you can grab it from there
                $request->auth = $user;
                return $next($request);

            } catch (Exception $e) {
                return ApiResponse::unauthorized();
            }
        } else {
            return ApiResponse::unauthorized();
        }
    }
}