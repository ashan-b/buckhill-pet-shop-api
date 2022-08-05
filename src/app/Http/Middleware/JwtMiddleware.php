<?php

namespace App\Http\Middleware;

use App\Http\Traits\JwtTokenHelper;
use App\Http\Traits\ResponseGenerator;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class JwtMiddleware
{
    use JwtTokenHelper;
    use ResponseGenerator;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $bearerToken = $request->bearerToken();
            if ($bearerToken === null) {
                return $this->sendError("Auth token not found.", [], [], 401);
            }
            $jwtToken = $this->parseJwtToken($bearerToken);
            if ($jwtToken === null) {
                return $this->sendError("Unauthorized.", [], [], 401);
            }
            $is_admin = $jwtToken->claims()->get('is_admin');
            if ($is_admin == true && in_array("ADMIN", $roles)) {
                return $next($request);
            }
            if ($is_admin == false && in_array("USER", $roles)) {
                return $next($request);
            }
            return $this->sendError("Forbidden.", [], [], 403);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], App::hasDebugModeEnabled() ? $e->getTrace() : [], 422);
        }
    }
}
