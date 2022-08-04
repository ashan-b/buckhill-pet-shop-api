<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserController\UserCreateRequest;
use App\Http\Requests\Api\V1\UserController\UserLoginRequest;
use App\Http\Requests\Api\V1\UserController\UserLogoutRequest;
use App\Http\Traits\JwtTokenHelper;
use App\Http\Traits\ResponseGenerator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{

    use JwtTokenHelper;
    use ResponseGenerator;

    /**
     * @OA\Tag(
     *     name="User",
     *     description="User API endpoint"
     * )
     *
     * @OA\Post(
     *     path="/api/v1/user/create",
     *     summary="Create a User account",
     *     tags={"User"},
     *     @OA\RequestBody(
     *     required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"first_name","last_name","email","password","password_confirmation","address_title","phone_number"},
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string",
     *                     description="User firstname"
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     description="User lastname"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="User lastname"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="User password"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     description="User password confirmation"
     *                 ),
     *                 @OA\Property(
     *                     property="avatar",
     *                     type="string",
     *                     description="Avatar image UUID"
     *                 ),
     *                 @OA\Property(
     *                     property="address_title",
     *                     type="string",
     *                     description="Address Title"
     *                 ),
     *                  @OA\Property(
     *                     property="address_line_1",
     *                     type="string",
     *                     description="Address Line 1"
     *                 ),
     *                  @OA\Property(
     *                     property="address_line_2",
     *                     type="string",
     *                     description="Address Line 2"
     *                 ),
     *                  @OA\Property(
     *                     property="address_line_3",
     *                     type="string",
     *                     description="Address Line 3"
     *                 ),
     *                  @OA\Property(
     *                     property="address_line_4_city",
     *                     type="string",
     *                     description="Address Line 4 - City"
     *                 ),
     *                  @OA\Property(
     *                     property="address_line_5_state",
     *                     type="string",
     *                     description="Address Line 5 - State"
     *                 ),
     *                   @OA\Property(
     *                     property="address_line_6_zip",
     *                     type="string",
     *                     description="Address Line 6 - ZIP"
     *                 ),
     *                  @OA\Property(
     *                     property="address_line_7_country",
     *                     type="string",
     *                     description="Address Line 7 - Country"
     *                 ),
     *                  @OA\Property(
     *                     property="phone_number_country_code",
     *                     type="string",
     *                     description="Phone Number - Country Code"
     *                 ),
     *                   @OA\Property(
     *                     property="phone_number",
     *                     type="string",
     *                     description="Phone Number"
     *                 ),
     *                   @OA\Property(
     *                     property="is_marketing",
     *                     type="string",
     *                     description="User marketing preferences"
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
    public function create(UserCreateRequest $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->is_admin = false;
        $user->password = Hash::make($request->password);
        $user->uuid = Str::uuid()->toString();
        $user->save();

        $token = $this->generateJwtToken($user);

        return $this->sendSuccess(
            [
                'uuid' => $user->uuid,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'address_title' => $user->address_title,
                'address_line_1' => $user->address_line_1,
                'address_line_2' => $user->address_line_2,
                'address_line_3' => $user->address_line_3,
                'address_line_4_city' => $user->address_line_4_city,
                'address_line_5_state' => $user->address_line_5_state,
                'address_line_6_zip' => $user->address_line_6_zip,
                'address_line_7_country' => $user->address_line_7_country,
                'phone_number_country_code' => $user->phone_number_country_code,
                'phone_number' => $user->phone_number,
                'is_marketing' => $user->is_marketing,
                'updated_at' => $user->updated_at,
                'created_at' => $user->created_at,
                'token' => $token
            ]
        );
    }


    /**
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
        }
        return $this->sendError("Failed to authenticate user", [], null, 422);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/user/logout",
     *     summary="Logout an User account",
     *     tags={"User"},
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
    public function logout(UserLogoutRequest $request)
    {
        $bearerToken = $request->bearerToken();
        $tokenInvalidated = $this->invalidateJwtToken($bearerToken);

        if ($tokenInvalidated === true) {
            return $this->sendSuccess([]);
        }

        return $this->sendError("Invalid token.", [], null, 422);
    }

}
