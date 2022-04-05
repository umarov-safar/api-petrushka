<?php
namespace App\Services;

use App\Dtos\BrandDto;
use App\Models\Brand;

class BrandService {

    public function create(BrandDto $request)
    {
        $brand  = new Brand();

        $brand->name = $request->getName();
        $brand->slug = $request->getSlug();

        if(!$brand->save()) {
            return false;
        }

        return $brand;
    }


    public function update(BrandDto $request, int $id)
    {
        $brand  = Brand::find($id);

        $brand->name = $request->getName();
        $brand->slug = $request->getSlug();

        if(!$brand->save()) {
            return false;
        }

        return $brand;
    }

}
