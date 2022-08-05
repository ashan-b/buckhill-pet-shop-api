<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $uuid
 * @property string $last_name
 * @property bool $is_admin
 * @property string|null $avatar
 * @property string|null $address_title
 * @property string|null $address_line_1
 * @property string|null $address_line_2
 * @property string|null $address_line_3
 * @property string|null $address_line_4_city
 * @property string|null $address_line_5_state
 * @property string|null $address_line_6_zip
 * @property string|null $address_line_7_country
 * @property string|null $phone_number_country_code
 * @property string|null $phone_number
 * @property bool $is_marketing
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property mixed $0
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JwtToken[] $jwtTokens
 * @property-read int|null $jwt_tokens_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressLine3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressLine4City($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressLine5State($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressLine6Zip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressLine7Country($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsMarketing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumberCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUuid($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'is_admin',
        'avatar',
        'address_title',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'address_line_4_city',
        'address_line_5_state',
        'address_line_6_zip',
        'address_line_7_country',
        'phone_number_country_code',
        'phone_number',
        'is_marketing',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uuid'=>'string',
        'first_name'=>'string',
        'last_name'=>'string',
        'email'=>'string',
        'email_verified_at',
        'password'=>'string',
        'remember_token'=>'string',
        'is_admin'=>'boolean',
        'avatar'=>'string',
        'address_title'=>'string',
        'address_line_1'=>'string',
        'address_line_2'=>'string',
        'address_line_3'=>'string',
        'address_line_4_city'=>'string',
        'address_line_5_state'=>'string',
        'address_line_6_zip'=>'string',
        'address_line_7_country'=>'string',
        'phone_number_country_code'=>'string',
        'phone_number'=>'string',
        'is_marketing'=>'boolean',
        'last_login_at'=> 'datetime',
        'email_verified_at' => 'datetime'
    ];

    /**
     * Get the JWT tokens associated with the user.
     */
    public function jwtTokens()
    {
        return $this->hasMany(JwtToken::class);
    }

}
