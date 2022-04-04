<?php
namespace App\Services;

use App\Dtos\ManufacturerDto;
use App\Models\Manufacturer;

class ManufacturerService {

    public function create(ManufacturerDto $request)
    {
        $manufacturer = new Manufacturer();

        $manufacturer->name = $request->getName();

        if(!$manufacturer->save()) {
            return false;
        }

        return $manufacturer;
    }


    public function update(ManufacturerDto $request, int $id)
    {
        $manufacturer = Manufacturer::find($id);

        $manufacturer->name = $request->getName();

        if(!$manufacturer->save()) {
            return false;
        }

        return $manufacturer;
    }

}
