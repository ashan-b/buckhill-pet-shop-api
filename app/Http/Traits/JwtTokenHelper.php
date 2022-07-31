<?php

namespace App\Http\Traits;

use App\Models\JwtToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer;

trait JwtTokenHelper
{
    private $config;

    public function __construct()
    {
        $privateKeyPath = env("JWT_PRIVATE_KEY_PATH");
        $publicKeyPath = env("JWT_PUBLIC_KEY_PATH");

        $this->config = Configuration::forAsymmetricSigner(
            new Signer\Rsa\Sha256(),
            InMemory::file(base_path($privateKeyPath)),
            InMemory::file(base_path($publicKeyPath))
        );
    }

    public function generateJwtToken(User $user)
    {

        $now = new \DateTimeImmutable();
        $expiresAt = $now->modify('+1 day');

        $unique_id= Str::uuid()->toString();

        $token = $this->config->builder()
            ->issuedBy(request()->root())
            ->withClaim('user_uuid', $user->uuid)
            ->withClaim('unique_id', $unique_id)
            ->issuedAt($now)
            ->expiresAt($expiresAt)
            ->getToken($this->config->signer(), $this->config->signingKey());

        $jwtToken = new JwtToken;
        $jwtToken->user_id = $user->id;
        $jwtToken->unique_id = $unique_id;
        $jwtToken->token_title = "API";
        $jwtToken->restrictions = [];
        $jwtToken->permissions = [];
        $jwtToken->expires_at = $expiresAt;
        $jwtToken->save();

        return $token->toString();
    }

    public function validateJwtToken($bearerToken)
    {

        $parsedJwtToken = $this->config->parser()->parse($bearerToken);

        $unique_id = $parsedJwtToken->claims()->get('unique_id');

        $jwtToken = JwtToken::where('unique_id', $unique_id)->first();
        if ($parsedJwtToken != null && $jwtToken !== null && $jwtToken->expires_at > Carbon::now()) {
            $jwtToken->last_used_at = Carbon::now();
            $jwtToken->save();
            return $jwtToken;
        }
        return null;
    }

    public function invalidateJwtToken($bearerToken)
    {
        $parsedJwtToken = $this->config->parser()->parse($bearerToken);
        $unique_id = $parsedJwtToken->claims()->get('unique_id');
        $jwtToken = JwtToken::where('unique_id',  $unique_id)->first();
        if ($jwtToken !== null) {
            $jwtToken->delete();
            return true;
        }
        return false;
    }

}
