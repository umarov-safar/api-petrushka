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
     * @param string $name
     * @param array|null $info
     * @param bool $isBlock
     * @param int $phone
     */
    public function __construct(
        string $name,
        ?array $info,
        bool $isBlock,
        int $phone
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
