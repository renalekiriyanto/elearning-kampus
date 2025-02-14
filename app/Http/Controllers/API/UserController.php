<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
    @route  /api/register
    @desc   Register user
    @access Public
    */
    public function register(Request $request){
        try {
            // Validation request input
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'role_user' => ['required', 'string']
            ]);

            // Create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user = User::where('email', $request->email)->first();

            // Generate token
            $token_result = $user->createToken(env('APP_KEY'))->plainTextToken;

            return response()->json([
                'success' => true,
                'msg' => 'User registered',
                'token_type' => 'Bearer',
                'access_token' => $token_result,
                'user' => $user
            ]);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Something went wrong',
                'error' => $error->getMessage()
            ], 500);
        }
    }

    public function login(Request $request){
        try {
            // Validation request input
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $credential = request(['email', 'password']);

            // Check user is exists
            if(!Auth::attempt($credential)){
                return response()->json([
                    'success' => false,
                    'msg' => 'Authentication failed'
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            // Check password is correct
            if(!Hash::check($request->password, $user->password, [])){
                throw new Exception('Invalid credential');
            }

            // Generate token
            $token = $user->createToken(env('APP_KEY'))->plainTextToken;

            return response()->json([
                'success' => true,
                'msg' => 'User logged in',
                'token_type' => 'Bearer',
                'access_token' => $token
            ]);

        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'msg' => 'Authentication failed',
                'error' => $error->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request){
        $token = $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'msg' => 'User logged out'
        ]);
    }
}
