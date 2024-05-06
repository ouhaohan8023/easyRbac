<?php

namespace Ouhaohan8023\EasyRbac\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Ouhaohan8023\EasyRbac\Service\PermissionService;
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
            // 路由是否需要鉴权
            $permissionArray = PermissionService::getCachedPermission();

            $route = $request->route()->getName();
            $needRbac = Arr::get($permissionArray, $route, false); //判断当前路由是否需要鉴权
            if ($needRbac === false) {
                return response()->json([
                    'code' => 500,
                    'msg' => '非法访问，当前路由不存在',
                ], 200);
            }

            if ($needRbac) {
                // 路由需要鉴权
                if (! $user->can($route)) {
                    return response()->json([
                        'code' => 500,
                        'msg' => '当前用户无权限访问此路由',
                    ], 200);
                }
            }
        }

        return $next($request);
    }
}
