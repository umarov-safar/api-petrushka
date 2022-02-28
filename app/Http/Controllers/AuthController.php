<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Ease login to system if phone not exist will be created
     * @param PhoneRequest $request
     */
    public function login(PhoneRequest $request)
    {

        $user = User::updateOrCreate(
            ['phone' => $request->phone],
            ['code' => random_int(100000, 999999) ] // generate code for message
        );

        /*
         * Logic for sending code to user
         * To access new code use
         * $user->code
         */

        return response($user);

    }

    /**
     * Check if code exist create token
     */
    public function checkCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = User::wherePhone($request->phone)
                    ->whereCode($request->code)
                    ->get()
                    ->first();

        if($user) {

            $token = $user->createToken("auth"); // create token

            return response([
                'user' => $user,
                'token' => $token->plainTextToken
            ]);
        }

        return  response(['message' => 'неверный код'], 404);

    }

    /**
     * Logout and remove all token specific user
     *
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response(['message' => 'Вы вышли из системы']);
    }

}
