<?php
namespace App\Services;

use App\Dtos\PartnerUserDto;
use App\Models\PartnerUser;
use App\Models\User;

class PartnerUserService {

    public function create(PartnerUserDto $request)
    {
        $partner_user = new PartnerUser();

        $user = User::firstOrCreate(['phone' => $request->getPhone()]);

        $partner_user->user_id = $user->id;
        $partner_user->partner_id = $request->getPartnerId() ?? auth()->user()->partnerOwner->id;
        $partner_user->phone = $request->getPhone();
        $partner_user->setting_info = $request->getSettingInfo();
        $partner_user->status = $request->getStatus();
        $partner_user->is_admin = $request->getIsAdmin();

        if(!$partner_user->save()) return false;

        return $partner_user;
    }


    public function update(PartnerUserDto $request, int $id)
    {
        $partner_user = PartnerUser::find($id);

        $partner_user->phone = $request->getPhone();
        $partner_user->setting_info = $request->getSettingInfo();
        $partner_user->status = $request->getStatus();
        $partner_user->is_admin = $request->getIsAdmin();

        if(!$partner_user->save()) return false;

        return $partner_user;
    }

}
