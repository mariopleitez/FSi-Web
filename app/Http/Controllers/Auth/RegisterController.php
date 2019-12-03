<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Profile;
use App\Models\SocialProvider;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
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
        return $this->issueToken21($user);
        // $user->token;
    }

    private function issueToken21(User $user) {
        $userToken = $user->token() ?? $user->createToken('socialLogin');

        return [
            "token_type"    => "Bearer",
            "access_token"  => $userToken->accessToken,
        ];
    }

    
}
