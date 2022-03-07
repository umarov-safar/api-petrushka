<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;

class AuthController extends Controller
{

    /**
     * Авторизация из админ-панели
     * @param PhoneRequest $request
     * @return bool
     */
    public function loginAdmin(PhoneRequest $request){
        return $this->login($request, 'admin');
    }

    /**
     * Авторизация из покупатель-панели
     * @param PhoneRequest $request
     * @return bool
     */
    public function loginCustomer(PhoneRequest $request){
        return $this->login($request, 'customer');
    }

    /**
     * Авторизация из партнёр-панели
     * @param PhoneRequest $request
     * @return bool
     */
    public function loginPartner(PhoneRequest $request){
        return $this->login($request, 'partner');
    }

    /**
     * Ease login to system if phone not exist will be created
     * @param PhoneRequest $request
     */
    private function login(PhoneRequest $request, $type)
    {
        $return = FALSE;
        switch ($type){
            case 'customer':
                $user = User::updateOrCreate(
                    ['phone' => $request->phone],
                    ['code' => random_int(100000, 999999) ] // generate code for message
                );
                $user->assign('customer'); // привязать пользователя к роли "Покупатель"

                $return = TRUE;
                break;
            case 'partner':
                $user = User::firstWhere('phone', $request->phone);
                $return = FALSE;
                if($user && Bouncer::is($user)->a('partner'))
                    $return = TRUE;
                break;
            case 'admin':
                $user = User::firstWhere('phone', $request->phone);
                $return = FALSE;
                if($user && Bouncer::is($user)->a('superadmin', 'admin'))
                    $return = TRUE;
                break;
        }

        /*
         * Logic for sending code to user
         * To access new code use
         * $user->code
         */

        //return response($user); // нельзя так делать, т.к. ты сразу возвращаешь в объекте код для смс для любого номера телефона
        if (!$return){
            return  response(['message' => 'Пользователь не найден'], 404);
        }
        return response($return);

    }


    /**
     * Check if code exist create token
     */
    public function checkCodeAdmin(Request $request){
        return $this->checkCode($request, 'admin');
    }

    /**
     * Check if code exist create token
     */
    public function checkCodePartner(Request $request){
        return $this->checkCode($request, 'partner');
    }

    /**
     * Check if code exist create token
     */
    public function checkCodeCustomer(Request $request){
        return $this->checkCode($request, 'customer');
    }

    /**
     * Check if code exist create token
     */
    private function checkCode(Request $request, $type)
    {
        /*
         * проверки:
         *  пользователь существует;
         *  проверить роль пользователя;
         *
         * */
        $request->validate([
            'code' => 'required|digits:6',
        ]);
        $user = User::wherePhone($request->phone)
            ->whereCode($request->code)
            ->get()
            ->first();

        if($user) {
            $token = NULL;
            switch ($type){
                case 'customer':
                    if(Bouncer::is($user)->a('customer')){
                        $token = $user->createToken("auth"); // create token
                    }
                    break;
                case 'partner':
                    if(Bouncer::is($user)->a('partner')){
                        $token = $user->createToken("auth"); // create token
                    }
                    break;
                case 'admin':
                    if(Bouncer::is($user)->a('superadmin', 'admin')){
                        $token = $user->createToken("auth"); // create token
                    }
                    break;
            }
            if($token){
                return response([
                    'user' => $user,
                    'token' => $token->plainTextToken
                ]);
            }
        }

        return  response(['message' => 'Неверный код'], 404);

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
