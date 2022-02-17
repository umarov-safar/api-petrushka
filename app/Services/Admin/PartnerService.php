<?php
namespace App\Services\Admin;

use App\Dtos\Admin\PartnerDto;
use App\Models\Admin\Partner;

class PartnerService {

    public function create(PartnerDto $request)
    {
        $partner = new Partner();

        $partner->name = $request->getName();
        $partner->info = $request->getInfo();
        $partner->phone = $request->getPhone();
        $partner->admin_user_id = $request->getAdminUserId();
        $partner->is_block = $request->isBlock();

        if(!$partner->save()) return false;

        return $partner;

    }


    public function update(PartnerDto $request, int $id)
    {
        $partner = Partner::find($id);

        $partner->name = $request->getName();
        $partner->info = $request->getInfo();
        $partner->phone = $request->getPhone();
        $partner->admin_user_id = $request->getAdminUserId();
        $partner->is_block = $request->isBlock();

        if(!$partner->save()) return false;

        return $partner;
    }

}
