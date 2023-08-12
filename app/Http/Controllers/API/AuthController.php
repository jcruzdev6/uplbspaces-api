<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Log;

class AuthController extends Controller
{
    public function index(User $user)
    {
        return response()->json([
            'data' => $user->latest()->get(),
        ]);
    }

    public function signin(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login details'
            ], 401);
        }
        Log::debug('User authenticated!');
        $request->session()->regenerate();
        return response()->json([
            'success' => true
        ], 200);
    }

    public function signout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function me(Request $request)
    {
        $data = new UserResource($request->user());
        return $data;
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function redirectToProvider($provider = 'google')
    {
       // return Socialite::driver($provider)->redirectUrl(env('GOOGLE_REDIRECT_URI'))->redirect();
        $state = Session::get('_token');
        return Socialite::driver($provider)->stateless()->redirectUrl(env('GOOGLE_REDIRECT_URI'))->stateless()->with(['state' => $state])->redirect();

    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Log::error($e);
            return redirect('/api/login')->withErrors(['auth' => 'Failed to authenticate with ' . $provider]);
        }

        $authUser = $this->findOrCreateUser($user, $provider);

        auth()->login($authUser, true);
        $token = $user->createToken('token-name')->plainTextToken;
        return redirect('/api/user?token=' . $token . '&origin=login');
    }    

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->orWhere('provider_id', $user->id)->first();

        if ($authUser) {
            return $authUser;
        }

        $authUser = new User();
        $authUser->email = $user->email;
        $authUser->provider = $provider;
        if ($provider != '') $authUser->provider_id = $user->id;
        $authUser->password = Hash::make($user->password);
        $authUser->save();

        return $authUser;
    }
    /**
     * @param $provider
     * @return JsonResponse
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'github', 'google'])) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }
    }

}