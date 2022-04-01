<?php
namespace App\Services;

use App\Dtos\CategoryDto;
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
        $category->attributes = $request->getAttributes();
        $category->is_alcohol = $request->getIsAlcohol();

        return $category;
    }

}
