<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\UserDto;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Users\UserQuery;
use App\JsonApi\Admin\V1\Users\UserRequest;
use App\JsonApi\Admin\V1\Users\UserMeRequest;
use App\JsonApi\Admin\V1\Users\UserSchema;
use App\Models\User;
use App\Services\UserService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Contracts\Routing\Route;
use LaravelJsonApi\Contracts\Store\Store as StoreContract;
use LaravelJsonApi\Laravel\Http\Requests\ResourceQuery;

class UserController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
//    use Actions\Store;
//    use Actions\Update;
//    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    /**
     * @var UserService
     */
    protected UserService $userService;


    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Create user
     * @param UserSchema $userSchema
     * @param UserRequest $request
     * @param UserQuery $query
     */
    public function store(UserSchema $userSchema, UserRequest $request, UserQuery $query)
    {
        /*
         * Заметки
         * 1. Роль Партнер
         *  создать партнер и партнер юзер
         * 2. Роль покупатель
         * */
        $attributes = $request->data['attributes'];

        $roles = $request->data['relationships']['roles']['data'] ?? null;
        $abilities = $request->data['relationships']['abilities']['data'] ?? null;

        $roles = $roles ? pluckIds($roles) : $roles;
        $abilities = $abilities ? pluckIds($abilities) : $abilities;

        $dto = new UserDto(
            $attributes['name'] ?? null,
            $attributes['email'] ?? null,
            $attributes['isBlock'] ?? User::BLOCK_NO,
            $attributes['phone'],
            $attributes['code'] ?? null,
            $roles,
            $abilities
        );

        $user = $this->userService->create($dto);

        if(!$user) {
            return false;
        }

        $user = User::find($user->getKey());
        return new DataResponse($user);
    }


    /**
     * Update user
     * @param UserSchema $userSchema
     * @param UserRequest $request
     * @param UserQuery $query
     * @return false|DataResponse
     */
    public function update(UserSchema $userSchema, UserRequest $request, UserQuery $query, User $user)
    {
        $attributes = $request->data['attributes'];

        $roles = $request->data['relationships']['roles']['data'] ?? null;
        $abilities = $request->data['relationships']['abilities']['data'] ?? null;

        $roles = $roles ? pluckIds($roles) : $roles;
        $abilities = $abilities ? pluckIds($abilities) : $abilities;

        $dto = new UserDto(
            $attributes['name'] ?? $user->name ?? null,
            $attributes['email'] ?? $user->email ?? null,
            $attributes['isBlock'] ?? $user->is_block ?? User::BLOCK_NO,
            $user->phone, //$attributes['phone'],  Запрещено менять номер телефона
            $user->code,//$attributes['code'] ?? null,
            $roles,
            $abilities,
        );

        $user = $this->userService->update($dto, $user->id);

        if(!$user) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $user = User::find($user->getKey());
        return new DataResponse($user);
    }

    /**
     * Удаление существующего ресурса. Замена на блокирвку пользователя.
     *
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function destroy(UserRequest $request, User $user)
    {
        //var_dump($user->roles());
        //exit;
        $dto = new UserDto(
            $user->name,
            $user->email,
            User::BLOCK_YES,
            $user->phone, //$attributes['phone'],  Запрещено менять номер телефона
            $user->code,//$attributes['code'] ?? null,
            NULL,
            NULL,
        );



        $user = $this->userService->update($dto, $user->id);

        if(!$user) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $user = User::find($user->getKey());
        return new DataResponse($user);
    }

    /**
     * Показать профиль текущего пользователя.
     *
     * @param UserSchema $schema
     * @param UserQuery $request
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */

    public function showMe(UserSchema $schema, UserQuery $request)
    {
        $user = auth()->user();
        if(!$user){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }
        //var_dump($user->id);
        //exit;

        $model = $schema
            ->repository()
            ->queryOne($user)
            ->withRequest($request)
            ->first();

        // do something custom...

        return new DataResponse($model);
    }

    /**
     * Изменить профиль текущего пользователя.
     *
     * @todo Проверка на разблокировку, т.к. сейчас каждый пользователь может сам себя заблокировать и разблокировать.
     *
     * @param UserSchema $schema
     * @param UserRequest $request
     * @param UserQuery $query
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function updateMe(
        UserSchema $schema,
        UserMeRequest $request,
        UserQuery $query
    ) {
        $user = auth()->user();
        if(!$user){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }
        return $this->update($schema, $request, $query, $user);
    }

    public function checkCode(\Request $request){
        echo "test\n";
        var_dump($request);
    }

    /*
    public function logout(){
        $user = auth()->user();
        if($user){
            $authController = new AuthController();
            return $authController->logout();
        }
        return response(['message' => 'Проблема'], 204);

    }*/

}
