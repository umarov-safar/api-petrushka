<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\RoleDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Roles\RoleQuery;
use App\JsonApi\Admin\V1\Roles\RoleRequest;
use App\JsonApi\Admin\V1\Roles\RoleSchema;
use App\Models\Role;
use App\Services\RoleService;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class RoleController extends Controller
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

    protected RoleService $roleService;


    public function __construct()
    {
        $this->roleService = new RoleService();
    }

    /**
     * Create Role
     * @param RoleSchema $schema
     * @param RoleRequest $request
     * @param RoleQuery $query
     * @return false|DataResponse
     */
    public function store(RoleSchema $schema, RoleRequest $request, RoleQuery $query): false|DataResponse
    {

        $attributes = $request->data['attributes'];

        $abilities = $request->data['relationships']['abilities']['data'] ?? null;
        $users = $request->data['relationships']['users']['data'] ?? null;

        $abilitiesIds = [];
        if($abilities) {
            $abilitiesIds = collect($abilities)->pluck('id')->toArray();
        }

        $usersIds = [];
        if($users) {
            $usersIds = collect($users)->pluck('id')->toArray();
        }


        $dto = new RoleDto(
            $attributes['name'],
            $attributes['title'] ?? null,
            $abilitiesIds,
            $usersIds,
            $attributes['level'] ?? null
        );

        $role = $this->roleService->create($dto);

        if(!$role) {
            return false;
        }

        $role = Role::find($role->getKey());
        return new DataResponse($role);
    }

    /**
     * Update role
     * @param RoleSchema $schema
     * @param RoleRequest $request
     * @param RoleQuery $query
     * @param Role $role
     * @return DataResponse
     */
    public function update(RoleSchema $schema, RoleRequest $request, RoleQuery $query, Role $role)
    {
        $attributes = $request->data['attributes'];

        $abilities = $request->data['relationships']['abilities']['data'] ?? null;
        $users = $request->data['relationships']['users']['data'] ?? null;

        $abilitiesIds = [];
        if($abilities) {
            $abilitiesIds = collect($abilities)->pluck('id')->toArray();
        }

        $usersIds = [];
        if($users) {
            $usersIds = collect($users)->pluck('id')->toArray();
        }


        $dto = new RoleDto(
            $attributes['name'],
            $attributes['title'] ?? null,
            $abilitiesIds,
            $usersIds,
            $attributes['level'] ?? null
        );

        $role = $this->roleService->update($dto, $role->id);

        $role = Role::find($role->getKey());
        return new DataResponse($role);

    }

}
