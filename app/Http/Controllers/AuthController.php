<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneRequest;
use App\Http\Requests\CodeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use Silber\Bouncer\BouncerFacade as Bouncer;
use LaravelJsonApi\Core\Responses\MetaResponse;
use App\JsonApi\Proxies\Account; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html

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
                //var_dump($type);
                $user->assign('customer'); // привязать пользователя к роли "Покупатель"

                $return = TRUE;
                break;
            case 'partner':
                $user = User::firstWhere('phone', $request->phone);
                $return = FALSE;
                if($user && Bouncer::is($user)->a('partner'))
                {
                    $return = TRUE;
                    $user->code = random_int(100000, 999999);
                    $user->save();
                }
                break;
            case 'admin':
                $user = User::firstWhere('phone', $request->phone);
                $return = FALSE;
                if($user && Bouncer::is($user)->a('superadmin', 'admin'))
                {
                    $return = TRUE;
                    $user->code = random_int(100000, 999999);
                    if($user->phone <> '79999999999') // superadmin
                        $user->save();
                }
                break;
        }

        /*
         * Logic for sending code to user
         * To access new code use
         * $user->code
         */

        //return response($user); // нельзя так делать, т.к. ты сразу возвращаешь в объекте код для смс для любого номера телефона
        if (!$return){
            //return  response(['message' => 'Пользователь не найден'], 404);

            $error = Error::make()
                ->setStatus(404)
                ->setDetail('Пользователь не найден.');
            return ErrorResponse::make($error);
        }



        // отправка смс с кодом
        //return response($return, 200);
        return new MetaResponse([
            'auth' => 'sending code',
            'phone' => $request->phone
        ]);

    }


    /**
     * Check if code exist create token
     */
    public function checkCodeAdmin(CodeRequest $request){
        return $this->checkCode($request, 'admin');
    }

    /**
     * Check if code exist create token
     */
    public function checkCodePartner(CodeRequest $request){
        return $this->checkCode($request, 'partner');
    }

    /**
     * Check if code exist create token
     */
    public function checkCodeCustomer(CodeRequest $request){
        return $this->checkCode($request, 'customer');
    }

    /**
     * Check if code exist create token
     */
    private function checkCode(CodeRequest $request, $type)
    {
        /*
         * проверки:
         *  пользователь существует;
         *  проверить роль пользователя;
         *
         * */
        /*
        var_dump($request->phone);
        var_dump($request->code);
        exit;*/
        /*$request->validate([
            'code' => 'required|digits:6',
        ]);*/
        $user = User::wherePhone($request->phone)
            ->whereCode($request->code)
            ->get()
            ->first();

        if($user) {
            $token = NULL;
            $account = NULL;
            $jsonApiServer = NULL;
            switch ($type){
                case 'customer':
                    if(Bouncer::is($user)->a('customer')){
                        $token = $user->createToken("auth"); // create token
                        // вернуть объект account + токен через meta
                        //$account = new AccountPartner($user);
                        $account = new Account($user);
                        $jsonApiServer = 'Customer\V1';
                    }
                    break;
                case 'partner':
                    if(Bouncer::is($user)->a('partner')){
                        $token = $user->createToken("auth"); // create token
                        // вернуть объект account + токен через meta
                        $account = new Account($user);
                        $jsonApiServer = 'Partner\V1';
                    }
                    break;
                case 'admin':
                    if(Bouncer::is($user)->a('superadmin', 'admin')){
                        $token = $user->createToken("auth"); // create token
                        // вернуть объект account + токен через meta
                        $account = new Account($user);
                        $jsonApiServer = 'Admin\V1';
                    }
                    break;
            }
            if($token && $account){
                return DataResponse::make($account)
                    ->withServer($jsonApiServer)
                    ->withHeader('token', $token->plainTextToken)
                    ->withMeta(['token' => $token->plainTextToken]);
                /*
                return response([
                    'user' => $user,
                    'token' => $token->plainTextToken
                ]);*/
            }
        }

        $error = Error::make()
            ->setStatus(404)
            ->setDetail('Неверный код.');
        return ErrorResponse::make($error);
    }

    /**
     * Logout and remove all token specific user
     *
     */
    public function logout()
    {
        //auth()->user()->tokens()->delete(); // данный код удаляет все токены со всех устройств
        auth()->user()->currentAccessToken()->delete();
    }

}
