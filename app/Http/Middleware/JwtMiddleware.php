<?php

namespace App\Http\Middleware;

use App\Http\Traits\JwtTokenHelper;
use App\Http\Traits\ResponseGenerator;
use App\Models\JwtToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lcobucci\JWT\Configuration;

class JwtMiddleware
{
    use JwtTokenHelper;
    use ResponseGenerator;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $bearerToken= $request->bearerToken();

            if($bearerToken==null){
                return $this->sendError("Auth token not found.", [], [], 403);
            }

             $jwtToken = $this->validateJwtToken($bearerToken);

            if($jwtToken!=null){
                return $next($request);
            }else{
                return $this->sendError("Invalid auth token.", [], [], 403);
            }


        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], $e->getTrace(), 422);
        }

    }
}
