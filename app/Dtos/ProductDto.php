<?php
namespace App\Dtos;

class ProductDto {

    protected string $name;

    protected string $sku;

    protected string $description;

    protected string $description_original;

    protected string $slug;

    protected int $category_id;

    protected bool $is_alcohol;

    protected ?string $human_volume;

    protected ?string $canonical_permalink;

    protected ?int $brand_id;

    protected ?int $manufacturer_id;

    protected ?int $manufacturing_country_id;

    protected ?int $partner_id;

    protected ?array $attributes;

    /**
     * @param string $name
     * @param string $sku
     * @param string $description
     * @param string $description_original
     * @param string $slug
     * @param int $category_id
     * @param bool $is_alcohol
     * @param string|null $human_volume
     * @param string|null $canonical_permalink
     * @param int|null $brand_id
     * @param int|null $manufacturer_id
     * @param int|null $manufacturing_country_id
     * @param int|null $partner_id
     * @param string|null $attributes
     */
    public function __construct(
        string $name,
        string $sku,
        string $description,
        string $description_original,
        string $slug,
        int $category_id,
        bool $is_alcohol,
        ?string $human_volume,
        ?string $canonical_permalink,
        ?int $brand_id,
        ?int $manufacturer_id,
        ?int $manufacturing_country_id,
        ?int $partner_id,
        ?array $attributes
    )
    {
        $this->name = $name;
        $this->sku = $sku;
        $this->description = $description;
        $this->description_original = $description_original;
        $this->slug = $slug;
        $this->category_id = $category_id;
        $this->is_alcohol = $is_alcohol;
        $this->human_volume = $human_volume;
        $this->canonical_permalink = $canonical_permalink;
        $this->brand_id = $brand_id;
        $this->manufacturer_id = $manufacturer_id;
        $this->manufacturing_country_id = $manufacturing_country_id;
        $this->partner_id = $partner_id;
        $this->attributes = $attributes;
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
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getDescriptionOriginal(): string
    {
        return $this->description_original;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    /**
     * @return bool
     */
    public function getIsAlcohol(): bool
    {
        return $this->is_alcohol;
    }

    /**
     * @return string|null
     */
    public function getHumanVolume(): ?string
    {
        return $this->human_volume;
    }

    /**
     * @return string|null
     */
    public function getCanonicalPermalink(): ?string
    {
        return $this->canonical_permalink;
    }

    /**
     * @return int|null
     */
    public function getBrandId(): ?int
    {
        return $this->brand_id;
    }

    /**
     * @return int|null
     */
    public function getManufacturerId(): ?int
    {
        return $this->manufacturer_id;
    }

    /**
     * @return int|null
     */
    public function getManufacturingCountryId(): ?int
    {
        return $this->manufacturing_country_id;
    }

    /**
     * @return int|null
     */
    public function getPartnerId(): ?int
    {
        return $this->partner_id;
    }

    /**
     * @return array|null
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }



}
