<?php
namespace App\Dtos;

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
     * @var array|null
     */
    protected ?array $roles;


    /**
     *
     */
    protected ?array $abilities;


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
        ?int $code,
        ?array $roles,
        ?array $abilities
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->isBlock = $isBlock;
        $this->phone = $phone;
        $this->code = $code;
        $this->roles = $roles;
        $this->abilities = $abilities;
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

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @return array|null
     */
    public function getAbilities(): ?array
    {
        return $this->abilities;
    }




}
