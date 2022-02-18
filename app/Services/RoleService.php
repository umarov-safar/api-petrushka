<?php
namespace App\Services;

use App\Dtos\RoleDto;
use App\Models\Role;

class RoleService {

    /**
     * Create role
     * @param RoleDto $request
     * @return Role|false
     */
    public function create(RoleDto $request)
    {
        $role = new Role();

        $role->name = $request->getName();
        $role->title = $request->getTitle();
        $role->level = $request->getLevel();


        if($role->save()) {

            $role->users()->sync($request->getUsersIds());
            $role->abilities()->attach($request->getAbilitiesIds());

            return $role;
        }

        return false;
    }

    /**
     * Update role
     * @param RoleDto $request
     * @param int $id
     * @return false|Role
     */
    public function update(RoleDto $request, int $id)
    {
        $role = Role::find($id);

        $role->name = $request->getName();
        $role->title = $request->getTitle();
        $role->level = $request->getLevel();

        if($role->save()) {

            $role->users()->sync($request->getUsersIds());
            $role->abilities()->attach($request->getAbilitiesIds());

            return $role;
        }

        return false;
    }

}
