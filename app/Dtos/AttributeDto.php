<?php
namespace App\Dtos;

class AttributeDto {

    /**
     * @var string $name
     */
    protected string $name;

    /**
     * @var string $type
     */
    protected string $type;

    /**
     * @var $slug
     */
    protected string $slug;

    /**
     * @var int $position
     */
    protected int $position;

    /**
     * @var int|null
     */
    protected ?int $partner_id;

    /**
     * @param string $name
     * @param string $type
     * @param string $slug
     * @param int $position
     * @param int|null $partner_id
     */
    public function __construct(string $name, string $type, string $slug, int $position, ?int $partner_id)
    {
        $this->name = $name;
        $this->type = $type;
        $this->slug = $slug;
        $this->position = $position;
        $this->partner_id = $partner_id;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return int|null
     */
    public function getPartnerId(): ?int
    {
        return $this->partner_id;
    }


}
