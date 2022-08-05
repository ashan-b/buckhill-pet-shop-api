<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AdminController\AdminLoginRequest;
use App\Http\Requests\Api\V1\AdminController\AdminLogoutRequest;
use App\Http\Traits\JwtTokenHelper;
use App\Http\Traits\ResponseGenerator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use JwtTokenHelper;
    use ResponseGenerator;

    /**
     *  * @OA\Tag(
     *     name="Admin",
     *     description="Admin API endpoint"
     * )
     * /
     *
     * /*
     * @OA\Post(
     *     path="/api/v1/admin/login",
     *     summary="Login an Admin account",
     *     tags={"Admin"},
     *     @OA\RequestBody(
     *     required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"email","password"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Admin email",
     *                     example="admin@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="Admin password",
     *                     example="password"
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

        $user = User::where('email', $email)->where('is_admin', true)->first();

        if ($user !== null && Hash::check($password, $user->password)) {
            $token = $this->generateJwtToken($user);
            if ($token === null) {
                abort(500);
            }

            return $this->sendSuccess(["token" => $token]);
        }
        return $this->sendError("Failed to authenticate user", [], null, 422);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/logout",
     *     summary="Logout an Admin account",
     *     tags={"Admin"},
     *     security={{"bearerAuth":{}}},
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
    public function logout(AdminLogoutRequest $request)
    {
        $bearerToken = $request->bearerToken();
        $tokenInvalidated = $this->invalidateJwtToken($bearerToken);

        if ($tokenInvalidated === true) {
            return $this->sendSuccess([]);
        }

        return $this->sendError("Invalid token.", [], null, 422);
    }
}
