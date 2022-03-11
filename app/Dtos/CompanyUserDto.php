<?php
namespace App\Dtos;

class CompanyUserDto {

    /**
     * @var int
     */
    protected int $company_id;

    /**
     * @var string
     */
    protected string $phone;

    /**
     * @var array|null
     */
    protected ?array $setting_info;

    /**
     * @var bool
     */
    protected bool $status;

    /**
     * @var bool
     */
    protected bool $isAdmin;

    /**
     * @param int $user_id
     * @param int $company_id
     * @param string $phone
     * @param array|null $setting_info
     * @param bool $status
     * @param bool $isAdmin
     */
    public function __construct(
        int $company_id,
        string $phone,
        ?array $setting_info,
        bool $status,
        bool $isAdmin
    )
    {
        $this->company_id = $company_id;
        $this->phone = $phone;
        $this->setting_info = $setting_info;
        $this->status = $status;
        $this->isAdmin = $isAdmin;
    }


    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return array|null
     */
    public function getSettingInfo(): ?array
    {
        return $this->setting_info;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }



}
