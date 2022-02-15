<?php
namespace App\Dtos\Admin;

class UserDto {

    /**
     * @var string|null
     */
    protected ?string $name;

    /**
     * @var string|null
     */
    protected ?string $email;

    /**
     * @var bool
     */
    protected bool $isBlock;

    /**
     * @var int
     */
    protected int $phone;


    /**
     * @var int|null
     */
    protected ?int $code;

    /**
     * @param string|null $name
     * @param string|null $email
     * @param bool $isBlock
     * @param int $phone
     */
    public function __construct(
        ?string $name,
        ?string $email,
        bool $isBlock,
        int $phone,
        ?int $code
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->isBlock = $isBlock;
        $this->phone = $phone;
        $this->code = $code;
    }



    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
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
    public function getPhone(): int
    {
        return $this->phone;
    }

    /**
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

}
