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
use LaravelJsonApi\Core\Responses\DataResponse;
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
    use Actions\Destroy;
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
        $attributes = $request->data['attributes'];

        $roles = $request->data['relationships']['roles']['data'] ?? null;
        $abilities = $request->data['relationships']['abilities']['data'] ?? null;

        $roles = $roles ? pluckIds($roles) : $roles;
        $abilities = $abilities ? pluckIds($abilities) : $abilities;

        $dto = new UserDto(
            $attributes['name'] ?? null,
            $attributes['email'] ?? null,
            $attributes['isBlock'] ?? 0,
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
            $attributes['name'] ?? null,
            $attributes['email'] ?? null,
            $attributes['isBlock'] ?? 0,
            $user->phone, //$attributes['phone'],  Запрещено менять номер телефона
            $user->code,//$attributes['code'] ?? null,
            $roles,
            $abilities,
        );

        $user = $this->userService->update($dto, $user->id);

        if(!$user) {
            return false;
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
        if(!$user) return response(['message' => 'Неверный код'], 204);
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
        if(!$user) return response(['message' => 'Неверный код'], 204);
        return $this->update($schema, $request,$query, $user);
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
