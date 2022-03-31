<?php

namespace App\Http\Controllers\Api\Partner\V1;

use App\Dtos\CompanyDto;
use App\Dtos\PartnerDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Partner\V1\MyCompanies\MyCompanyQuery;
use App\JsonApi\Partner\V1\MyCompanies\MyCompanyRequest;
use App\JsonApi\Partner\V1\MyCompanies\MyCompanySchema;
use App\Models\Partner;
use App\JsonApi\Proxies\MyCompany; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use App\Services\PartnerService;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\ErrorResponse;

class MyCompanyController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
//    use Actions\Store;
//    use Actions\Update;
//    use Actions\Destroy;
   /* use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;*/


    /**
     * @var PartnerService
     */
    protected PartnerService $partnerService;


    public function __construct()
    {
        $this->partnerService = new PartnerService();
    }

    /**
     * Update partner
     * @param MyCompanySchema $schema
     * @param MyCompanyRequest $request
     * @param MyCompanyQuery $query
     * @param MyCompany $partner
     * @return false|DataResponse|\Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function update(MyCompanySchema $schema, MyCompanyRequest $request, MyCompanyQuery $query, MyCompany $partner)
        //public function update()
    {
        $attributes = $request->data['attributes'];

        $dto = new PartnerDto(
            $attributes['name'] ?? $partner->name,
            $attributes['info'] ?? $partner->info,
            $partner->is_block, // пользователь-партнер не может менять состояние блокировки
            $partner->phone, //$attributes['phone'],  Запрещено менять номер телефона
        );

        $partner = $this->partnerService->update($dto, $partner->id);

        if(!$partner){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $partner = Partner::find($partner->getKey());
        $partner = new MyCompany($partner);
        return new DataResponse($partner);
    }

    /**
     * Fetch zero to one JSON API resource by id.
     *
     * @param MyCompanySchema $schema
     * @param MyCompanyQuery $request
     * @param MyCompany $partner
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function showNew(MyCompanySchema $schema, MyCompanyQuery $request, MyCompany $partner)
    {
        //dd($partner);

        $model = $schema
            ->repository()
            ->queryOne($partner)
            ->withRequest($request)
            ->first();


        // do something custom...

        return new DataResponse($model);
    }
}
