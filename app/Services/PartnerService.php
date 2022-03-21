<?php
namespace App\Services;

use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\User;
use Silber\Bouncer\BouncerFacade as Bouncer;

// DTOs
use App\Dtos\PartnerUserDto;
use App\Dtos\PartnerDto;
use App\Dtos\UserDto;

// Services
use App\Services\PartnerUserService;
use App\Services\UserService;


class PartnerService {

    public function create(PartnerDto $request)
    {
        /**
         *  Алгоритм:
         * 1. Создать или получить пользователя по номеру телефона;
         * 2. Проверить ,что у пользователя нет роли partnerAdmin или partnerEmployee
         * 3. Установить ему роль partner и partnerAdmin
         * 4. Создать партнер
         * 5. создать partner_user с указанием админа пользователя
         */

        //get user by phone or create new to save id to user_admin_id field in partner table
        //$user = User::firstOrCreate(['phone' => $request->getPhone()]);
        $adminUser = User::where('phone', $request->getPhone())->first();
        if($adminUser){
            if(Bouncer::is($adminUser)->notAn('partnerAdmin', 'partnerEmployee')){
                $adminUser->assign('partner'); // привязать пользователя к роли "partnerAdmin"
                $adminUser->assign('partnerAdmin'); // привязать пользователя к роли "partnerAdmin"
            } else {
                // запретить создавать партнера, т.к. пользователь уже является админом в другой компании или является сотрудником
                return false;
            }
        } else {
            // создаем пользователя и назначаем роль "partner"
            // создать пользователя и выставить ему роль partnerAdmin
            $dto = new UserDto(
                null,
                null,
                User::BLOCK_NO,
                $request->getPhone(),
                null,
                null,
                null
            );
            $userService = new UserService();
            if(!$adminUser = $userService->create($dto)){
                \Log::debug($adminUser);
                return false;
            }
            $adminUser->assign('partner'); // привязать роль

        }

        // создание партнера
        $partner = new Partner();
        $partner->name = $request->getName();
        $partner->info = $request->getInfo();
        $partner->phone = $request->getPhone();
        $partner->admin_user_id = $adminUser->id;
        $partner->is_block = $request->isBlock();

        if(!$partner->save()) return false;

        // создание записи в partner_user с пометкой, что user админ
        $dto = new PartnerUserDto(
            $adminUser->phone,
            [],
            0,
            PartnerUser::IS_ADMIN_YES,
            $partner->id
        );
        $partnerUserService = new PartnerUserService();
        $partnerUser = $partnerUserService->create($dto);
        $adminUser->assign('partnerAdmin'); // привязать роль

        return $partner;
    }


    /**
     * Update partner data
     * @param PartnerDto $request
     * @param int $id
     * @return Partner|false
     */
    public function update(PartnerDto $request, int $id)
    {
        /**
         *  Алгоритм:
         * 1. Получить прошлого админа
         * 2. Сравнить номер старого админа с новым номером
         * 2.1. "Совпадают"
         *  2.1.1. ничего не делаем с юзером, только меняем данные партнера
         * 2.2. "Не совпадают"
         *  2.2.1. Меняем номер телефона и user_id
         *  2.2.2. Меняем данные партнера
         *  2.2.3. Удаляем пометку о старом админе в partner_user
         *  2.2.4. Создаем или обновляем нового админа в partner_user
         *
         */

        $partner = Partner::find($id);

        $partner->name = $request->getName();
        $partner->info = $request->getInfo();
        //$partner->phone = $request->getPhone(); // Запрещено менять телефон
        $partner->is_block = $request->isBlock();

        if(!$partner->save()) return false;

        return $partner;
    }

}
