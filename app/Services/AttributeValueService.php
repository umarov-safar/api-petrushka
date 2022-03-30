<?php
namespace App\Services;

use App\Dtos\AttributeValueDto;
use App\Models\AttributeValue;

class AttributeValueService {

    /**
     * @param AttributeValueDto $request
     * @return AttributeValue|false
     */
    public function create(AttributeValueDto $request)
    {
        $attributeValue = new AttributeValue();

        $attributeValue->value = $request->getValue();
        $attributeValue->partner_id = $request->getPartnerId();
        $attributeValue->is_global = $request->getIsGlobal();
        $attributeValue->attribute_id = $request->getAttributeId();
        $attributeValue->position = $request->getPosition();

        if(!$attributeValue->save()) {
            return false;
        }

        return $attributeValue;
    }


    public function update(AttributeValueDto $request, int $id)
    {
        $attributeValue = AttributeValue::find($id);

        $attributeValue->value = $request->getValue();
        $attributeValue->partner_id = $request->getPartnerId();
        $attributeValue->is_global = $request->getIsGlobal();
        $attributeValue->attribute_id = $request->getAttributeId();
        $attributeValue->position = $request->getPosition();

        if(!$attributeValue->save()) {
            return false;
        }

        return $attributeValue;
    }

}
