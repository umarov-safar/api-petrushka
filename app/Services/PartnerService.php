<?php
namespace App\Services;

use App\Dtos\PartnerDto;
use App\Models\Partner;
use App\Models\User;

class PartnerService {

    public function create(PartnerDto $request)
    {
        $partner = new Partner();

        //get user by phone or create new to save id to user_admin_id field in partner table
        $user = User::firstOrCreate(['phone' => $request->getPhone()]);

        $partner->name = $request->getName();
        $partner->info = $request->getInfo();
        $partner->phone = $request->getPhone();
        $partner->admin_user_id = $user->id;
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
        $partner->is_block = $request->isBlock();

        if(!$partner->save()) return false;

        return $partner;
    }

}
