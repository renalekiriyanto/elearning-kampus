<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
    @route      GET /login
    @desc       Login form
    @access     Public
    */
    public function login(){
        return view('auth.login');
    }

    /*
    @route      POST /login
    @desc       Login authorize
    @access     Public
    */
    public function loginAuth(Request $request){
        try {
            // Validation request input
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $credential = request(['email', 'password']);

            // Check user is exists
            if(!Auth::attempt($credential)){
                return redirect()->route('login')->with('error', 'Authentication failed');
            }

            $user = User::where('email', $request->email)->first();

            // Check password is correct
            if(!Hash::check($request->password, $user->password, [])){
                return redirect()->route('login')->with('error', 'Invalid credential');
            }

            // Generate token
            $token = $user->createToken(env('APP_KEY'))->plainTextToken;

            return redirect()->route('courses');

        } catch (Exception $error) {
            return redirect()->route('login')->with('error', $error->getMessage());
        }
    }

    /*
    @route      POST /logout
    @desc       Logout
    @access     Authenticated
    */
    public function logout(Request $request){
        try {
            Auth::logout();

            return redirect()->route('login');

        } catch (Exception $error) {
            return redirect()->route('login')->with('error', $error->getMessage());
        }
    }
}
