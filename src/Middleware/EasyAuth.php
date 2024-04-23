<?php

namespace Ouhaohan8023\EasyRbac\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EasyAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $enableMiddleware = config('easy-rbac.enable_middleware', true);
        if ($enableMiddleware) {
            $user = $request->user();
            if (! $user) {
                return response()->json([
                    'code' => 401,
                    'msg' => 'Unauthorized',
                ], 401);
            }
            $route = $request->route()->getName();
            if (! $user->can($route)) {
                return response()->json([
                    'code' => 500,
                    'msg' => '当前用户无权限访问此路由',
                ], 200);
            }

        }

        return $next($request);

    }
}
