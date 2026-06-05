<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->hasAnyRole(['pro', 'admin'])) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Quyền lợi Pro yêu cầu để sử dụng tính năng này.'], 403);
            }
            // Trong thực tế sẽ redirect sang trang báo giá/nâng cấp
            abort(403, 'Unauthorized action. Pro required.');
        }

        return $next($request);
    }
}
