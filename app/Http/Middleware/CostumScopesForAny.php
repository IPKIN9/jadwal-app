<?php

namespace App\Http\Middleware;

use Closure;

class CostumScopesForAny
{
    public function handle($request, Closure $next, ...$scopes)
    {
        if (!$request->user() || !$request->user()->token()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        foreach ($scopes as $scope) {
            if ($request->user()->tokenCan($scope)) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Insufficient scope.'], 403);
    }
}
