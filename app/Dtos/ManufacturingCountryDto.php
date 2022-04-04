<?php
namespace App\Dtos;

class ManufacturingCountryDto {

    protected string $name;


    protected string $slug;


    /**
     * @param string $name
     * @param string $slug
     */
    public function __construct(string $name, string $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
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
    public function getSlug(): string
    {
        return $this->slug;
    }

}
