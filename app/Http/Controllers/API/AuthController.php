<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserResource;
use App\Http\Resources\API\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Mail\SignupMailable;
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
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                Log::debug('Account not verified');
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is not yet verified. Click the verify link in the welcome email.'
                ], 401);
            } else {
                Log::debug('User authenticated!');
                $request->session()->regenerate();
                return response()->json([
                    'success' => true
                ], 200);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid login details'
        ], 401);
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

    public function profile(Request $request)
    {
        $data = new UserProfileResource($request->user());
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

    public function findOrCreateUser($user, $provider = '')
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

    public function signup(Request $request)
    {
        $authUser = User::where('email', $request->email)->first();

        if ($authUser) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the email you have entered is already in use.'
            ], 401);
        }

        $authUser = new User();
        $authUser->email = $request->email;
        $authUser->password = Hash::make($request->password);
        $authUser->verification_token = sha1(time().$request->email);
        if ($authUser->save()) {
            Mail::to($request->email)->send(new SignupMailable($authUser));
            //$request->session()->regenerate();
            return response()->json([
                'success' => true,
                'message' => 'Signup successful. Please check your email for verification.'
            ], 200);
            return response()->json(['success' => true], 200);            
        } else {
            return response()->json([
                'success' => false,
                'message' => 'An error was encountered. Try again later'
            ], 400);
        }

    }
    
    public function verify(Request $request) {

        $user = User::where('email', $request->email)->first();
        Log::info('verify called');
        Log::info($request);
        if(!$user->is_verified && $user->verification_token == $request->token) {
            $user->markEmailAsVerified();
            Log::info('Account is now verified. Click Sign-in to login to your account.');
            return response()->json([
                'success' => true,
                'message' => 'Account is now verified. Click Sign-in to login to your account.'
            ], 200);
        } elseif ($user->is_verified) {
            Log::info('Account was already verified. Click Sign-in to login to your account.');
            return response()->json([
                'success' => false,
                'message' => 'Account was already verified. Click Sign-in to login to your account.'
            ], 200);
        } else {
            Log::info('Invalid verification link');
            return response()->json([
                'success' => false,
                'message' => 'Error! Account is not verified. The verification link is invalid.'
            ], 400);
        }       
    }

    public function updateProfile(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        Log::info('updateProfile called. ID:'.$request->id);
        Log::info( $request);
        if ($user) {
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->account_type = $request->account_type;
            if ($request->department_unit_id != 'null' && $request->department_unit_id > 0) {
                Log::info('department_unit_id set');
                $user->department_unit_id = $request->department_unit_id;
            }    
            $user->organization = $request->organization;
            $user->id_type = $request->id_type;
            $user->id_no = $request->id_no;
            if ($request->hasFile('id_file')) {
                $id = $request->file('id_file');
                $path = $request->file('id_file')->store('id');
                //$filepath = 'id-'.$user->id.'.'.$id->getClientOriginalExtension();
                $user->id_filepath = $path;
            }
            if ($user->save()) {
                //if ($request->hasFile('id_file'))
                //    $request->file('id_file')->store('/id/'.$filepath);

                return response()->json([
                    'success' => true,
                    'message' => 'Your profile was sucessfully updated.'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error! Failed to update profile. Please contact support.'
                ], 400);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Error! Account does not exist.'
        ], 400);
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