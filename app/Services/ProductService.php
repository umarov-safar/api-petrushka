<?php
namespace App\Services;

use App\Dtos\ProductDto;
use App\Models\AttributeValue;
use App\Models\Product;

class ProductService {


    public function create(ProductDto $request)
    {
        $product = self::setModelProperties($request, new Product());

        if(!$product->save()) {
            return false;
        }

        return  $product;
    }


    public function update(ProductDto $request, int $id)
    {
        $product = self::setModelProperties($request, Product::find($id));

        if(!$product->save()) {
            return false;
        }

        return  $product;
    }

    private static function setModelProperties(ProductDto $request, Product $product) : Product
    {
        $product->name = $request->getName();
        $product->sku = $request->getSku();
        $product->description = $request->getDescription();
        $product->description_original = $request->getDescriptionOriginal();
        $product->slug = $request->getSlug();
        $product->human_volume = $request->getHumanVolume();
        $product->canonical_permalink = $request->getCanonicalPermalink();
        $product->is_alcohol = $request->getIsAlcohol();
        $product->brand_id = $request->getBrandId();
        $product->category_id = $request->getCategoryId();
        $product->manufacturer_id = $request->getManufacturerId();
        $product->manufacturing_country_id = $request->getManufacturingCountryId();
        $product->partner_id = $request->getPartnerId();

        // если проверка не прйден то поле attribute будет NULL
        if($attributes = $request->getAttributes()) {
            $attributesIds = collect($attributes)->pluck('id')->toArray();

            $attributeOriginal = Product::whereIn('id', $attributesIds)
                ->get(['id', 'name', 'slug'])
                ->toArray();

            $attributesForSave = [];

            foreach ($attributes as $key => $attr) {
                foreach ($attributeOriginal as $keyOriginal => $attrOriginal)
                {
                    if($attr['id'] === $attrOriginal['id'])
                    {
                        //if presentation field is null/empty then put name of attribute to it
                        if(!isset($attr['presentation']) || empty($attr['presentation'])) {
                            $attr['presentation'] = $attrOriginal['name'];
                        }

                        // if position not isset
                        if(!isset($attr['position'])) $attr['position'] = 0;

                        // if attribute is list by value_id set attribute's value
                        if(isset($attr['value_id'])) {
                            $attr['value'] = AttributeValue::find($attr['value_id'])->value;
                        }

                        $attributesForSave[] = array_merge($attrOriginal, $attr);
                    }
                }
            }
            $product->attributes = $attributesForSave;
        }

        return $product;
    }
}
