<?php
namespace App\Http\Traits;

use App\Models\JwtToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer;

trait JwtTokenHelper{

    public function generateJwtToken(User $user){
        $privateKeyPath = env("JWT_PRIVATE_KEY_PATH");
        $publicKeyPath = env("JWT_PUBLIC_KEY_PATH");

        $config = Configuration::forAsymmetricSigner(
            new Signer\Rsa\Sha256(),
            InMemory::file(base_path($privateKeyPath)),
            InMemory::file(base_path($publicKeyPath))
        );

        $now = new \DateTimeImmutable();
        $expiresAt = $now->modify('+1 day');

        $token = $config->builder()
            ->issuedBy(request()->root())
            ->withClaim('user_uuid', $user->uuid)
            ->issuedAt($now)
            ->expiresAt($expiresAt)
            ->getToken($config->signer(), $config->signingKey());

        $jwtToken = new JwtToken;
        $jwtToken->user_id=$user->id;
        $jwtToken->unique_id=$token->toString();
        $jwtToken->token_title="API";
        $jwtToken->restrictions=[];
        $jwtToken->permissions=[];
        $jwtToken->expires_at=$expiresAt;
        $jwtToken->save();

        return $token->toString();
    }

    public function validateJwtToken($bearerToken){
        $privateKeyPath = env("JWT_PRIVATE_KEY_PATH");
        $publicKeyPath = env("JWT_PUBLIC_KEY_PATH");

        $config = Configuration::forAsymmetricSigner(
            new Signer\Rsa\Sha256(),
            InMemory::file(base_path($privateKeyPath)),
            InMemory::file(base_path($publicKeyPath))
        );

        $parsedJwtToken = $config->parser()->parse($bearerToken);

//        dd($parsedJwtToken->toString());
        $jwtToken = JwtToken::where('unique_id','=',$bearerToken)->first();
        if($jwtToken!==null && $jwtToken->expires_at > Carbon::now()){
            $jwtToken->last_used_at = Carbon::now();
            $jwtToken->save();
            return $jwtToken;
        }else{
            return null;
        }


    }

}
