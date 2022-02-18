<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\UserDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Users\UserQuery;
use App\JsonApi\Admin\V1\Users\UserRequest;
use App\JsonApi\Admin\V1\Users\UserSchema;
use App\Models\User;
use App\Services\UserService;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

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

        $dto = new UserDto(
            $attributes['name'] ?? null,
            $attributes['email'] ?? null,
            $attributes['isBlock'] ?? null,
            $attributes['phone'],
            $attributes['code'] ?? null,
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

        $dto = new UserDto(
            $attributes['name'] ?? null,
            $attributes['email'] ?? null,
            $attributes['isBlock'] ?? null,
            $attributes['phone'],
            $attributes['code'] ?? null,
        );

        $user = $this->userService->update($dto, $user->id);

        if(!$user) {
            return false;
        }

        $user = User::find($user->getKey());
        return new DataResponse($user);
    }

}
