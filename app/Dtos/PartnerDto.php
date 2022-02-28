<?php
namespace App\Dtos;

class PartnerDto {

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var array|null
     */
    protected ?array $info;

    /**
     * @var bool
     */
    protected bool $isBlock;

    /**
     * @var int
     */
    protected int $phone;


    /**
     * @param int $inn
     * @param array|null $info
     * @param bool $isBlock
     * @param int $adminUserId
     */
    public function __construct(
        string $name,
        int $phone,
        ?array $info,
        bool $isBlock,
    )
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->info = $info;
        $this->isBlock = $isBlock;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPhone(): int
    {
        return $this->phone;
    }

    /**
     * @return array|null
     */
    public function getInfo(): ?array
    {
        return $this->info;
    }

    /**
     * @return bool
     */
    public function isBlock(): bool
    {
        return $this->isBlock;
    }



}
