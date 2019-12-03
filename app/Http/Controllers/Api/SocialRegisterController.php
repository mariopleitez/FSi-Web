<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\SocialProvider;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Laravel\Socialite\Facades\Socialite;

class SocialRegisterController extends ApiController
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)
                    //    ->stateless()
                        ->redirect();
        //return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from facebook.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
           // $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            return redirect('/');
        }
        //check if we have logged provider
        $socialProvider = SocialProvider::where('provider_id', $socialUser->getId())->first();
        if (!$socialProvider) {
          // crear un nuevo usuario y provider
            
            //  1. Verificar si existe algun usuario con el mismo email
            $user = User::where('email', $socialUser->getEmail())->first();

            //  2. Crear o no la actualizacion
            if (!$user) {
                $user = User::Create([
                    "email"    => $socialUser->getEmail(),
                    "name"     => $socialUser->getName(),
                    "password" => bcrypt('secret')
                ]);

                Profile::create([
                    "user_id" => $user->id
                ]);

            }
            
            $user->socialProviders()->create([
                "provider_id" => $socialUser->getId(),
                "provider"    => $provider
            ]);


        }else{
            $user = $socialProvider->user;
        }

        //auth()->login($user);
        //return redirect("/");
        //return $this->issueToken2($user);
        return response()->json($this->issueToken2($user), 200);
        // $user->token;
    }

    private function issueToken2(User $user) {
        $userToken = $user->token() ?? $user->createToken('socialLogin');

        return [
            "token_type" => "Bearer",
            "access_token" => $userToken->accessToken
        ];
    }

    public function personaltoken(Request $request){

       // return $request;

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = User::Create([
                "email"    => $request->email,
                "name"     => $request->name,
                "password" => bcrypt('secret')
            ]);

            $user->role()->attach(1);

            Profile::create([
                "user_id" => $user->id
            ]);

        }

        $userToken = $user->token() ?? $user->createToken('socialLogin-'.$user->id);
        return [
            "token_type" => "Bearer",
            "access_token" => $userToken->accessToken
        ];
    }
}
