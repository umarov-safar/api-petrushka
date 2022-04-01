<?php
namespace App\Services;

use App\Dtos\CategoryDto;
use App\Models\Attribute;
use App\Models\Category;

class CategoryService {

    /**
     * @param CategoryDto $request
     * @return Category|false
     */
    public function create(CategoryDto $request): bool|Category
    {
        $category = new Category();

        $category = self::setModelProperties($category, $request);

        if(!$category->save()) {
            return false;
        }

        return $category;
    }


    /**
     * @param CategoryDto $request
     * @param int $id
     * @return bool|Category
     */
    public function update(CategoryDto $request, int $id): bool|Category
    {
        $category = Category::find($id);

        $category = self::setModelProperties($category, $request);

        if(!$category->save())
        {
            return false;
        }

        return $category;
    }


    private function setModelProperties(Category $category, CategoryDto $request) : Category
    {
        $category->name = $request->getName();
        $category->type = $request->getType();
        $category->slug = $request->getSlug();
        $category->position = $request->getPosition();
        $category->active = $request->getActive();
        $category->partner_id = $request->getPartnerId();
        $category->parent_id = $request->getParentId();
        $category->icon_url = $request->getIconUrl();
        $category->alt_icon = $request->getAltIcon();
        $category->canonical_url = $request->getCanonicalUrl();
        $category->depth = $request->getDepth();
        $category->requirements = $request->getRequirements();
        $category->is_alcohol = $request->getIsAlcohol();

        // если проверка не прйден то поле attribute будет NULL
        if($attributes = $request->getAttributes()) {
            $attributesIds = collect($attributes)->pluck('id')->toArray();

            $attributeOriginal = Attribute::whereIn('id', $attributesIds)
                ->get(['id', 'name', 'slug'])
                ->toArray();

            $attributesForSave = [];

            foreach ($attributes as $key => $attr) {
                foreach ($attributeOriginal as $keyOriginal => $attrOriginal)
                {
                    if($attr['id'] === $attrOriginal['id'])
                    {
                        $attributesForSave[] = array_merge($attrOriginal, $attr);
                    }
                }
            }
            $category->attributes = $attributesForSave;
        }

        return $category;
    }

}
