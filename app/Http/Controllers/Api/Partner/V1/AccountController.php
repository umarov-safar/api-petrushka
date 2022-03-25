<?php

namespace App\Http\Controllers\Api\Partner\V1;

use App\Dtos\UserDto;
//use App\Dtos\PartnerDto;
use App\Http\Controllers\Controller;
use App\JsonApi\Partner\V1\Account\AccountQuery;
use App\JsonApi\Partner\V1\Account\AccountCollectionQuery;
use App\JsonApi\Partner\V1\Account\AccountRequest;
use App\JsonApi\Partner\V1\Account\AccountSchema;
use App\Models\User;
use Auth;
use App\JsonApi\Proxies\Account; // proxy model https://laraveljsonapi.io/docs/1.0/digging-deeper/proxies.html
use App\Services\UserService;
//use App\Services\PartnerService;
use LaravelJsonApi\Core\Document\Error;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Core\Responses\ErrorResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;
use LaravelJsonApi\Core\Responses\MetaResponse;
use App\Http\Controllers\AuthController;

class AccountController extends Controller
{

//    use Actions\FetchMany;
//    use Actions\FetchOne;
//    use Actions\Store;
//    use Actions\Update;
//    use Actions\Destroy;
//    use Actions\FetchRelated;
//    use Actions\FetchRelationship;
//    use Actions\UpdateRelationship;
//    use Actions\AttachRelationship;
//    use Actions\DetachRelationship;

    protected UserService $userService;
    //protected PartnerService $partnerService;
    protected User $user;


    public function __construct()
    {
        $this->userService = new UserService();
    }

    protected function getUser(){
        $this->user = Auth::user();
    }

    /**
     * Fetch zero to many JSON API resources.
     *
     * @param AccountSchema $schema
     * @param AccountCollectionQuery $request
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function index(AccountSchema $schema, AccountCollectionQuery $request)
    {
        $this->getUser();
        $account = new Account($this->user);

        $model = $schema
            ->repository()
            ->queryOne($account)
            ->withRequest($request)
            ->first();

        // do something custom...

        return new DataResponse($model);
    }


    /**
     * Update account
     * @param AccountSchema $schema
     * @param AccountRequest $request
     * @param AccountQuery $query
     * @return false|DataResponse
     */
    public function store(AccountSchema $schema, AccountRequest $request, AccountQuery $query)
    {
        $attributes = $request->data['attributes'];
        $this->getUser();

        $roles = $this->user->roles;
        if($roles)
            $roles = $roles->pluck('id')->all() ?? [];

        $abilities = $this->user->abilities;
        if($abilities)
            $abilities = $abilities->pluck('id')->all() ?? [];


        $dto = new UserDto(
            $attributes['name'] ?? $this->user->name ?? null,
            $attributes['email'] ?? $this->user->email ?? null,
            $this->user->is_block,
            $this->user->phone, //$attributes['phone'],  Запрещено менять номер телефона
            $this->user->code,//$attributes['code'] ?? null,
            $roles,
            $abilities,
        );

        $user = $this->userService->update($dto, $this->user->id);

        if(!$user) {
            $error = Error::make()
                ->setStatus(400)
                ->setDetail('Something was wrong with your request.');
            return ErrorResponse::make($error);
        }

        $user = User::find($user->getKey());
        $account = new Account($user);
        return new DataResponse($account);
    }



    /**
     * Удаление существующего ресурса. Замена на блокировку партнера.
     *
     * @param AccountRequest $request
     * @param Account $account
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    // public function destroy(AccountRequest $request, Account $account)
    public function logout()
    {
        $auth = new AuthController();
        $auth->logout();
        return new MetaResponse([
            'auth' => 'logout',
        ]);

    }
}
