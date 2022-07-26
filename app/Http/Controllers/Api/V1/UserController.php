<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserController\UserLoginRequest;
use App\Http\Traits\JwtTokenHelper;
use App\Http\Traits\ResponseGenerator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    use JwtTokenHelper;
    use ResponseGenerator;

    /**
     *  * @OA\Tag(
     *     name="User",
     *     description="User API endpoint"
     * )
     * /

    /*
     * @OA\Post(
     *     path="/api/v1/user/login",
     *     summary="Login an User account",
     *     tags={"User"},
    *     @OA\RequestBody(
     *     required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"email","password"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="User email"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="User password"
     *                 ),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Page not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function login(UserLoginRequest $request)
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
