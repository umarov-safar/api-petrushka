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
     * @param int $partner_id
     * @param string $phone
     * @param array|null $setting_info
     * @param bool $status
     */
    public function __construct(
        string $phone,
        ?array $setting_info,
        bool $status,
        ?int $partner_id,
    )
    {
        $this->phone = $phone;
        $this->setting_info = $setting_info;
        $this->status = $status;
        $this->partner_id = $partner_id;
    }


    /**
     * @return int|null
     */
    public function getPartnerId(): ?int
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
    public function isStatus(): bool
    {
        return $this->status;
    }


}
