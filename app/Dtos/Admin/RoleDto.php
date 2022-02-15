<?php
namespace App\Dtos\Admin;

class RoleDto {

    /**
     * @var string
     */
    protected string $name;


    /**
     * @var string
     */
    protected ?string $title;


    /**
     * @var int
     */
    protected ?int $level;


    /**
     * @var array|null
     */
    protected ?array $usersIds;


    /**
     * @var array|null
     */
    protected ?array $abilitiesIds;


    public function __construct(
        string $name,
        ?string $title,
        ?array $abilitiesIds,
        ?array $usersIds,
        ?int $level
    )
    {
        $this->name = $name;
        $this->title = $title;
        $this->abilitiesIds = $abilitiesIds;
        $this->usersIds = $usersIds;
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

    /**
     * @return array|null
     */
    public function getUsersIds(): ?array
    {
        return $this->usersIds;
    }

    /**
     * @return array|null
     */
    public function getAbilitiesIds(): ?array
    {
        return $this->abilitiesIds;
    }


}
