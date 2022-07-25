<?php

namespace App\Http\Controllers\Api\V1;

//use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AdminController\AdminLoginRequest;
use App\Http\Traits\JwtTokenHelper;
use App\Http\Traits\ResponseGenerator;
use App\Models\JwtToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    use JwtTokenHelper;
    use ResponseGenerator;

    public function __construct()
    {
    }

    public function login(AdminLoginRequest $request)
    {
        /*
        * User story:
        * valid JWT token must be created to enable access to protected routes.
        * This token must contain the user_uuid as a claim
        * The issuer must be the API server domain
        * The implementation must use an asymmetric key.
        */

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->where('is_admin', false)->first();

        if ($user != null && Hash::check($password, $user->password)) {
            $token = $this->generateJwtToken($user);
            if ($token == null) {
                abort(500);
            }

            return $this->sendSuccess(["token" => $token]);
        } else {
            return $this->sendError("Failed to authenticate user", [], null, 422);
        }
    }

}
