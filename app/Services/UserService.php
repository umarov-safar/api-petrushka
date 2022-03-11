<?php
namespace App\Services;

use App\Dtos\UserDto;
use App\Models\User;
use Silber\Bouncer\BouncerFacade as Bouncer;

// DTOs
use App\Dtos\PartnerDto;

// Services
use App\Services\PartnerService;

class UserService {

    public function create(UserDto $request)
    {
        /*
         * Должна быть проверка, что добавить можно только 4 роли при создании
         * superadmin, admin, customer, partner
         * */
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

        // если есть роль "partner", то создать партнёр
        if(Bouncer::is($user)->a('partner')){
            $dto = new PartnerDto(
                $user->phone,
                $user->phone,
                null,
                0,
            );
            $partnerService = new PartnerService();

            $partner = $partnerService->create($dto);
        }

        return  $user;
    }



    public function update(UserDto $request, int $id)
    {
        /*
         * Алгоритм при изменении роли
         * */
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
