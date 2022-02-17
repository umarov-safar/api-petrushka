<?php
namespace App\Services\Partner;

use App\Dtos\Partner\PartnerUserDto;
use App\Models\Partner\PartnerUser;

class PartnerUserService {

    public function create(PartnerUserDto $request)
    {
        $partner_user = new PartnerUser();

        $partner_user->user_id = $request->getUserId();
        $partner_user->partner_id = $request->getPartnerId();
        $partner_user->phone = $request->getPhone();
        $partner_user->setting_info = $request->getSettingInfo();
        $partner_user->status = $request->isStatus();

        if(!$partner_user->save()) return false;

        return $partner_user;
    }


    public function update(PartnerUserDto $request, int $id)
    {
        $partner_user = PartnerUser::find($id);

        $partner_user->user_id = $request->getUserId();
        $partner_user->partner_id = $request->getPartnerId();
        $partner_user->phone = $request->getPhone();
        $partner_user->setting_info = $request->getSettingInfo();
        $partner_user->status = $request->isStatus();

        if(!$partner_user->save()) return false;

        return $partner_user;
    }

}
