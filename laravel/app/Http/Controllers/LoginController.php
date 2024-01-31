<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\User;
use App\Notifications\LoginNeedsVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    public function submit(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|min:10'
        ]);

        $user = User::firstOrCreate(
            ['phone' => $request->phone]
        );

        if (!$user) {
            return response()->json([
                'message' => 'Could not process a user with that phone number.', 401
            ]);
        }

        Log::info("submit");

        $loginCode = rand(111111, 999999);

        $user->notify(new LoginNeedsVerification($loginCode));


        return response()->json(['message' => "Text message was sent {$loginCode}"]);
    }


    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|min:10',
            'login_code' => 'required|numeric|between:111111, 999999',
        ]);

        $user = User::where('phone', $request->phone)
            ->where('login_code', $request->login_code)
            ->first();

        if ($user) {
            $user->update(
                ['login_code' => null]
            );
            return $user->createToken($request->login_code)->plainTextToken;
        }

        return response()->json(['message' => 'Invalid verification code', 401]);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha',
            'email' => 'required|email',
            'password' => 'required|min:10',
        ]);

        $userExists = User::where('email', $request->email)->exists();

        if ($userExists) {
            return response()->json(['message' => 'Email Address already taken!'], 401);
        }

        $user = new User();

        $user->name = $request->get('name');
        $user->email = $request->get('email', null);
        $user->password = Hash::make($request->get('password'));

        $user->save();

        //TODO email verification necessary
        return response()->json(['message' => "User created, please login!"]);
    }

    public function verifyUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:10',
        ]);

        $user = User::where('email', $request->email)->first();
        $password = $request->get('password');


        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Email or password wrong!'], 401);
        }

        return $user->createToken($user->email)->plainTextToken;
    }
}

