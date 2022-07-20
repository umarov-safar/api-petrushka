<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Dtos\CategoryDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Admin\V1\Categories\CategoryQuery;
use App\JsonApi\Admin\V1\Categories\CategoryRequest;
use App\JsonApi\Admin\V1\Categories\CategorySchema;
use App\Models\Category;
use App\Services\CategoryService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class CategoryController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
//    use Actions\Store;
//    use Actions\Update;
//    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    protected CategoryService $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    public function store(CategorySchema $schema, CategoryRequest $request, CategoryQuery $query)
    {
        $attributes = $request->data['attributes'];

        $dto = new CategoryDto(
            $attributes['name'],
            $attributes['slug'],
            $attributes['categoryType'] ?? Category::TYPE_DEPARTMENT,
            $attributes['position'] ?? Category::DEFAULT_POSITION,
            $attributes['active'] ?? Category::ACTIVE_NO,
            $attributes['parentId'] ?? NULL,
            $attributes['relatedPartners'] ?? NULL,
            $attributes['iconUrl'] ?? NULL,
            $attributes['altIcon'] ?? NULL,
            $attributes['canonicalUrl'] ?? NULL,
            $attributes['depth'] ?? NULL,
            $attributes['requirements'] ?? NULL,
            $attributes['attributes'] ?? NULL,
            $attributes['isAlcohol'] ?? Category::IS_ALCOHOL_NO
        );

        $category = $this->categoryService->create($dto);

        if(!$category) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        return DataResponse::make($category);
    }


    public function update(CategorySchema $schema, CategoryRequest $request, CategoryQuery $query, Category $category)
    {
        $attributes = $request->data['attributes'];

        $dto = new CategoryDto(
            $attributes['name'],
            $attributes['slug'],
            $attributes['categoryType'] ?? Category::TYPE_DEPARTMENT,
            $attributes['position'] ?? Category::DEFAULT_POSITION,
            $attributes['active'] ?? Category::ACTIVE_NO,
            $attributes['parentId'] ?? $category->parent_id,
            $attributes['relatedPartners'] ?? $category->partner_id,
            $attributes['iconUrl'] ?? $category->icon_url,
            $attributes['altIcon'] ?? $category->alt_icon,
            $attributes['canonicalUrl'] ?? $category->canonical_url,
            $attributes['depth'] ?? $category->depth,
            $attributes['requirements'] ?? $category->requirements,
            $attributes['attributes'] ?? $category->attributes,
            $attributes['isAlcohol'] ?? Category::IS_ALCOHOL_NO
        );

        $updatedCategory = $this->categoryService->update($dto, $category->id);

        if(!$updatedCategory) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $category = Category::find($updatedCategory->getKey());
        return DataResponse::make($category);
    }

}
