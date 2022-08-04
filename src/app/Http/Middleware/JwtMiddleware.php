<?php

namespace App\Http\Middleware;

use App\Http\Traits\JwtTokenHelper;
use App\Http\Traits\ResponseGenerator;
use App\Models\JwtToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Lcobucci\JWT\Configuration;

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

            if ($jwtToken !== null) {
                $is_admin = $jwtToken->claims()->get('is_admin');

                if ($is_admin==true && in_array("ADMIN", $roles)) {
                    return $next($request);
                }else if($is_admin==false && in_array("USER", $roles)){
                    return $next($request);
                }else{
                    return $this->sendError("Forbidden.", [], [], 403);
                }
            }else{
                return $this->sendError("Unauthorized.", [], [], 401);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], App::hasDebugModeEnabled()?$e->getTrace():[], 422);
        }
    }
}
