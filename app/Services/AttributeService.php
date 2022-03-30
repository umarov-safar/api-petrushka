<?php
namespace App\Services;

use App\Dtos\AttributeDto;
use App\Models\Attribute;

class AttributeService {

    public function create(AttributeDto $request)
    {
        $attribute = new Attribute();

        $attribute->name = $request->getName();
        $attribute->type = $request->getType();
        $attribute->slug = $request->getSlug();
        $attribute->position = $request->getPosition();
        $attribute->partner_id = $request->getPartnerId();


        if(!$attribute->save())
        {
            return false;
        }

        return $attribute;

    }


    public function update(AttributeDto $request, int $id)
    {
        $attribute = Attribute::find($id);

        $attribute->name = $request->getName();
        $attribute->type = $request->getType();
        $attribute->slug = $request->getSlug();
        $attribute->position = $request->getPosition();
        $attribute->partner_id = $request->getPartnerId();


        if(!$attribute->save())
        {
            return false;
        }

        return $attribute;
    }

}
