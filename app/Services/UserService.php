<?php
namespace App\Services;

use App\Dtos\UserDto;
use App\Models\User;
use App\Models\Role;
use Silber\Bouncer\BouncerFacade as Bouncer;

// DTOs
use App\Dtos\PartnerDto;

// Services
use App\Services\PartnerService;

class UserService {

    /**
     * Создание нового пользователя
     * обязательно перед созданием проверить, что нет пользователя с таким номером телефона
     *
     * @param UserDto $request
     * @return void
     */
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
        // запрещено создавать сразу заблокированного пользователя, т.к. придётся писать много логики для ролей
        //$user->is_block = $request->isBlock();
        $user->is_block = User::BLOCK_NO;
        $user->code = $request->getCode();

        if(!$user->save()){
            return false;
        }

        // Проверка на привязку разрешенных в ручном режиме ролей
        // При создании пользователя можно привязать только разрешенные роли
        $roles = $request->getRoles();
        //\Log::info($request->getRoles());

        $checkedRoles = [];
        if($roles){
            // убираем не разрешенные роли
            $checkedRoles = $roles;
            foreach ($roles as $key=>$role){
                if(!in_array($role,Role::ALLOW_MANUALLY_SET_ROLES)){
                    unset($checkedRoles[$key]);
                }
            }
        }
        if($checkedRoles){
            //\Log::info($checkedRoles);
            $user->roles()->sync($checkedRoles);
        }

        // проверка для допустимых возможностей будет реализована на следующих этапах разработки
        if($request->getAbilities()) {
            $user->abilities()->sync($request->getAbilities());
        }

        // если есть роль "partner", то создать объект партнёр и данного пользователя сделать админом партнёра
        if(Bouncer::is($user)->a('partner')){
            $this->createPartner($user);
        }

        return  $user;
    }

    /**
     * Создание партнера
     *
     * @param User $user
     * @return void
     */
    private function createPartner(User $user){
        $dto = new PartnerDto(
            $user->phone,
            null,
            null,
            $user->phone,
        );
        $partnerService = new PartnerService();

        $partner = $partnerService->create($dto);
    }



    public function update(UserDto $request, int $id)
    {
        /*
         * Алгоритм при изменении роли
         * // Разрешено блокировать пользователя, если у него есть роль customerAdmin или partnerAdmin.
         * // запретить убирать роль Партнер если есть роль partnerAdmin или partnerEmployee
         * // запретить убирать роль Покупатель если есть роль customerAdmin или customerEmployee
         * // Вообзе запретить убирать роль customer или partner
         * */
        $user = User::find($id);
        $userBefore = clone $user;

        $user->name = $request->getName();
        $user->email = $request->getEmail();
        //$user->phone = $request->getPhone(); // Запрещено менять номер телефона у пользователя
        $user->is_block = $request->isBlock();
        $user->code = $request->getCode();

        if($user->id == 1){
            $user->is_block = User::BLOCK_NO; // запрет на блокировку суперадмина пользователя
        }

        // Ситуация когда админ редактирует пользователя и выставляет ему роль Партнёр
        // Ещё нужно проверить, что новые роли неразрешенные не добавляются вручную
        $isRolePartnerBefore = false;
        if(Bouncer::is($userBefore)->a('partner')){
            $isRolePartnerBefore = true; // т.е. до изменения уже была роль 'партнер'
        }

        if(!$user->save()) return false;

        $oldRoles = $userBefore->roles;
        if($oldRoles)
            $oldRoles = $oldRoles->pluck('id')->all() ?? [];

        // получить список отключаемых ролей
        // получить список новых включаемых ролей
        // Отключить можно только роли admin и superadmin

        $newRoles = $request->getRoles() ?? [];

        $oldTurnOffRoles =[];
        $newTurnOnRoles = [];
        $generalRoles = [];

        $oldTurnOffRoles = array_diff($oldRoles, $newRoles) ?? [];
        $newTurnOnRoles = array_diff($newRoles, $oldRoles) ?? [];
        $generalRoles = array_intersect($oldRoles, $newRoles) ?? [];
        /* echo '$oldRoles'."\n";
        var_dump($oldRoles);
        echo '$newRoles'."\n";
        var_dump($newRoles);
        echo '$oldTurnOffRoles'."\n";
        var_dump($oldTurnOffRoles);
        echo '$newTurnOnRoles'."\n";
        var_dump($newTurnOnRoles);
        echo '$generalRoles'."\n";
        var_dump($generalRoles); */

        /**
         * Логика.
         * Отключить можно только разрешенные для отключения роли.
         * проверяем отключаемые роли
         */
        $checkedOldTurnOffRoles = [];
        if($oldTurnOffRoles){
            $checkedOldTurnOffRoles = $oldTurnOffRoles;
            $disallowTurnOffRoles = array_merge(Role::DISALLOW_MANUALLY_SET_ROLES, Role::DISALLOW_MANUALLY_TURN_OFF_ROLES);
            //echo '$disallowTurnOffRoles'."\n";
            //var_dump($disallowTurnOffRoles);
            foreach ($oldTurnOffRoles as $key=>$role){
                if(!in_array($role, $disallowTurnOffRoles)){
                    unset($checkedOldTurnOffRoles[$key]);
                }
            }
        }

        /**
         * Логика.
         * Включить можно только разрешенные для ручной установки роли.
         * проверяем включаемые роли
         */
        $checkedNewTurnOnRoles = [];
        if($newTurnOnRoles){
            $checkedNewTurnOnRoles = $newTurnOnRoles;
            $allowTurnOnRoles = Role::ALLOW_MANUALLY_SET_ROLES;
            foreach ($newTurnOnRoles as $key=>$role) {
                if(!in_array($role, $allowTurnOnRoles)){
                    unset($checkedNewTurnOnRoles[$key]);
                }
            }
        }

         /* echo '$checkedOldTurnOffRoles'."\n";
         var_dump($checkedOldTurnOffRoles);
         echo '$checkedNewTurnOnRoles'."\n";
         var_dump($checkedNewTurnOnRoles);*/
        // объединяем все проверенные роли с общими ролями
        $checkedRoles = array_merge($generalRoles, array_merge($checkedOldTurnOffRoles, $checkedNewTurnOnRoles));
         /* echo '$checkedRoles'."\n";
         var_dump($checkedRoles);

         echo '$isRolePartnerBefore'."\n";
         var_dump($isRolePartnerBefore);
         exit; */


        /*
        $checkedRoles = [];
        if($newRoles){
            // убираем не разрешенные роли
            $checkedRoles = $newRoles;
            $allowManualRoles = array_merge(array_values(Role::ALLOW_MANUALLY_SET_ROLES), array_values($oldRoles)); // объединяем массив старых ролей с разрешенными
            foreach ($newRoles as $key=>$role){
                if(!in_array($role,$allowManualRoles)){
                    unset($checkedRoles[$key]);
                }
            }
        }*/

        if($checkedRoles){
            //\Log::info($checkedRoles);
            $user->roles()->sync($checkedRoles);
        }


        if($request->getAbilities()) {
            $user->abilities()->sync($request->getAbilities());
        }

        // если есть роль "partner", то создать объект партнёр и данного пользователя сделать админом партнёра
        if(Bouncer::is($user)->a('partner') && !$isRolePartnerBefore){
            $this->createPartner($user);
        }

        // запретить убирать роль покупатель и партнер, если он является админом

        return  $user;
    }


    public function destroy(int $id)
    {

    }

}
