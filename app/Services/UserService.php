<?php
namespace App\Services;

use App\Dtos\UserDto;
use App\Models\User;

class UserService {

    public function create(UserDto $request)
    {
        $user = new User();

        $user->name = $request->getName();
        $user->email = $request->getEmail();
        $user->phone = $request->getPhone();
        $user->is_block = $request->isBlock();
        $user->code = $request->getCode();

        if(!$user->save()){
            return false;
        }

        if($request->getRoles()){
            $user->roles()->sync($request->getRoles());
        }

        if($request->getAbilities()) {
            $user->abilities()->sync($request->getAbilities());
        }

        return  $user;
    }



    public function update(UserDto $request, int $id)
    {
        $user = User::find($id);

        $user->name = $request->getName();
        $user->email = $request->getEmail();
        $user->phone = $request->getPhone();
        $user->is_block = $request->isBlock();
        $user->code = $request->getCode();

        if(!$user->save()){
            return false;
        }

        if($request->getRoles()){
            $user->roles()->sync($request->getRoles());
        }

        if($request->getAbilities()) {
            $user->abilities()->sync($request->getAbilities());
        }

        return  $user;
    }

}
