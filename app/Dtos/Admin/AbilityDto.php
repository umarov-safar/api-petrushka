<?php
namespace App\Dtos\Admin;

class AbilityDto {

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string|null
     */
    protected ?string $title;


    public function __construct(string $name, ?string $title)
    {
        $this->name = $name;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }



}
