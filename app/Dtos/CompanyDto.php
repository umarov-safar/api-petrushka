<?php
namespace App\Dtos;

class CompanyDto {

    /**
     * @var int
     */
    protected int $inn;

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
    protected int $adminUserId;



    /**
     * @param int $inn
     * @param array|null $info
     * @param bool $isBlock
     * @param int $adminUserId
     */
    public function __construct(int $inn, ?array $info, bool $isBlock, int $adminUserId)
    {
        $this->inn = $inn;
        $this->info = $info;
        $this->isBlock = $isBlock;
        $this->adminUserId = $adminUserId;
    }

    /**
     * @return int
     */
    public function getInn(): int
    {
        return $this->inn;
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

    /**
     * @return int
     */
    public function getAdminUserId(): int
    {
        return $this->adminUserId;
    }




}
