<?php
namespace App\Services;

use App\Dtos\ManufacturingCountryDto;
use App\Models\ManufacturingCountry;

class ManufacturingCountryService {


    public function create(ManufacturingCountryDto $request)
    {
        $manufacturing_country  = new ManufacturingCountry();

        $manufacturing_country->name = $request->getName();
        $manufacturing_country->slug = $request->getSlug();

        if(!$manufacturing_country->save()) {
            return false;
        }

        return $manufacturing_country;
    }


    public function update(ManufacturingCountryDto $request, int $id)
    {
        $manufacturing_country  = ManufacturingCountry::find($id);

        $manufacturing_country->name = $request->getName();
        $manufacturing_country->slug = $request->getSlug();

        if(!$manufacturing_country->save()) {
            return false;
        }

        return $manufacturing_country;
    }
}
