<?php
namespace App\Dtos;

class CategoryDto {

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $slug;

    /**
     * @var int
     */
    protected int $type;

    /**
     * @var int
     */
    protected int $position;

    /**
     * @var int
     */
    protected int $active;

    /**
     * @var int|null
     */
    protected ?int $parent_id;

    /**
     * @var int|null
     */
    protected ?int $partner_id;

    /**
     * @var string|null
     */
    protected ?string $icon_url;

    /**
     * @var string|null
     */
    protected ?string $alt_icon;

    /**
     * @var string|null
     */
    protected ?string $canonical_url;

    /**
     * @var int|null
     */
    protected ?int $depth;

    /**
     * @var array|null
     */
    protected ?array $requirements;


    /**
     * @var array|null
     */
    protected ?array $attributes;

    /**
     * @var bool
     */
    protected bool $is_alcohol;

    /**
     * @param string $name
     * @param string $slug
     * @param int $type
     * @param int $position
     * @param int $active
     * @param int|null $parent_id
     * @param int|null $partner_id
     * @param string|null $icon_url
     * @param string|null $alt_icon
     * @param string|null $canonical_url
     * @param int|null $depth
     * @param string|null $requirements
     * @param string|null $attributes
     * @param bool $is_alcohol
     */
    public function __construct(
        string $name,
        string $slug,
        int $type,
        int $position,
        int $active,
        ?int $parent_id,
        ?int $partner_id,
        ?string $icon_url,
        ?string $alt_icon,
        ?string $canonical_url,
        ?int $depth,
        ?array $requirements,
        ?array $attributes,
        bool $is_alcohol
    )
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->type = $type;
        $this->position = $position;
        $this->active = $active;
        $this->parent_id = $parent_id;
        $this->partner_id = $partner_id;
        $this->icon_url = $icon_url;
        $this->alt_icon = $alt_icon;
        $this->canonical_url = $canonical_url;
        $this->depth = $depth;
        $this->requirements = $requirements;
        $this->attributes = $attributes;
        $this->is_alcohol = $is_alcohol;
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

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    /**
     * @return int|null
     */
    public function getPartnerId(): ?int
    {
        return $this->partner_id;
    }

    /**
     * @return string|null
     */
    public function getIconUrl(): ?string
    {
        return $this->icon_url;
    }

    /**
     * @return string|null
     */
    public function getAltIcon(): ?string
    {
        return $this->alt_icon;
    }

    /**
     * @return string|null
     */
    public function getCanonicalUrl(): ?string
    {
        return $this->canonical_url;
    }

    /**
     * @return int|null
     */
    public function getDepth(): ?int
    {
        return $this->depth;
    }

    /**
     * @return string|null
     */
    public function getRequirements(): ?array
    {
        return $this->requirements;
    }

    /**
     * @return string|null
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    /**
     * @return bool
     */
    public function getIsAlcohol(): bool
    {
        return $this->is_alcohol;
    }


}
