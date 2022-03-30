<?php
namespace App\Dtos;

class PartnerUserDto {

    /**
     * @var null|int
     */
    protected ?int $partner_id;

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
     * @param int $partner_id
     * @param string $phone
     * @param array|null $setting_info
     * @param bool $status
     * @param bool $isAdmin
     * @param bool $partner_id
     */
    public function __construct(
        string $phone,
        ?array $setting_info,
        bool $status,
        bool $isAdmin,
        int $partner_id
    )
    {
        $this->phone = $phone;
        $this->setting_info = $setting_info;
        $this->status = $status;
        $this->isAdmin = $isAdmin;
        $this->partner_id = $partner_id;
    }


    /**
     * @return int|null
     */
    public function getPartnerId(): int
    {
        return $this->partner_id;
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
