<?php
namespace App\Dtos;

class CompanyUserDto {

    /**
     * @var int
     */
    protected int $user_id;

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
     * @param int $user_id
     * @param int $company_id
     * @param string $phone
     * @param array|null $setting_info
     * @param bool $status
     */
    public function __construct(
        int $user_id,
        int $company_id,
        string $phone,
        ?array $setting_info,
        bool $status
    )
    {
        $this->user_id = $user_id;
        $this->company_id = $company_id;
        $this->phone = $phone;
        $this->setting_info = $setting_info;
        $this->status = $status;
    }


    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
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
    public function isStatus(): bool
    {
        return $this->status;
    }



}
