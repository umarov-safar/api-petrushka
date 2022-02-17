<?php
namespace App\Services\Admin;

use App\Dtos\Admin\AbilityDto;
use Silber\Bouncer\Database\Ability;

class AbilityService {

    /**
     * @param AbilityDto $request
     * @return false|Ability
     */
    public function create(AbilityDto $request): Ability|bool
    {
        $ability = new Ability();

        $ability->name = $request->getName();
        $ability->title = $request->getTitle();

        if($ability->save())
        {
            return $ability;
        }

        return false;

    }

    /**
     * @param AbilityDto $request
     * @param int $id
     * @return bool|Ability
     */
    public function update(AbilityDto $request, int $id): Ability|bool
    {
        $ability = Ability::find($id);

        $ability->name = $request->getName();
        $ability->title = $request->getTitle();

        if($ability->save())
        {
            return $ability;
        }

        return true;
    }

}
