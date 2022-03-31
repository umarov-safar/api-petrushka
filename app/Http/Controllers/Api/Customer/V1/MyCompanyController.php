<?php

namespace App\Http\Controllers\Api\Customer\V1;

use App\Dtos\CompanyDto;
use App\Dtos\PartnerDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Customer\V1\MyCompanies\MyCompanyQuery;
use App\JsonApi\Customer\V1\MyCompanies\MyCompanyRequest;
use App\JsonApi\Customer\V1\MyCompanies\MyCompanySchema;
use App\Models\Company;
use App\JsonApi\Proxies\MyCompanyCustomer as MyCompany; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use App\Services\CompanyService;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use Auth;

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
     * @var CompanyService
     */
    protected CompanyService $companyService;


    public function __construct()
    {
        $this->companyService = new CompanyService();
    }

    /**
     * Create company with JSON:API
     * @param MyCompanySchema $schema
     * @param MyCompanyRequest $request
     * @param MyCompanyQuery $query
     */
    public function store(MyCompanySchema $schema, MyCompanyRequest $request, MyCompanyQuery $query)
    {
        $attributes = $request->data['attributes'];

        $user = Auth::user();
        $dto = new CompanyDto(
            $attributes['inn'],
            $attributes['info'] ?? null,
            Company::BLOCK_NO,
            $user->phone
        );

        $company = $this->companyService->create($dto);

        if(!$company) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $company = Company::find($company->getKey());
        $company = new MyCompany($company);
        //\Log::info(print_r($company,true));
        return new DataResponse($company);
    }

    /**
     * Update partner
     * @param MyCompanySchema $schema
     * @param MyCompanyRequest $request
     * @param MyCompanyQuery $query
     * @param MyCompany $company
     * @return false|DataResponse|\Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */

    //public function update(PartnerSchema $schema, PartnerRequest $request, PartnerQuery $query, PartnerPartner $partner)
    public function update(MyCompanySchema $schema, MyCompanyRequest $request, MyCompanyQuery $query, MyCompany $company)
        //public function update()
    {
        $attributes = $request->data['attributes'];

        $dto = new CompanyDto(
            $attributes['inn'] ?? $company->inn,
            $attributes['info'] ?? $company->info,
            $company->is_block, // пользователь-партнер не может менять состояние блокировки
            $company->phone, //$attributes['phone'],  Запрещено менять номер телефона
        );

        $company = $this->companyService->update($dto, $company->id);

        if(!$company){
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $company = Company::find($company->getKey());
        $company = new MyCompany($company);
        return new DataResponse($company);
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
