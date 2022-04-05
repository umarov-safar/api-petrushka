<?php
namespace App\Dtos;

class AttributeValueDto {

    /**
     * @var string
     */
    protected string $value;

    /**
     * @var int|null
     */
    protected ?int $partner_id;

    /**
     * @var int
     */
    protected int $attribute_id;

    /**
     * @var int|null
     */
    protected ?int $position;


    /**
     * @var bool
     */
    protected bool $is_global;

    /**
     * @param string $value
     * @param int|null $partner_id
     * @param int $attribute_id
     * @param int|null $position
     * @param bool $is_global
     */
    public function __construct(string $value,  int $attribute_id, ?int $position, ?int $partner_id,  bool $is_global)
    {
        $this->value = $value;
        $this->partner_id = $partner_id;
        $this->attribute_id = $attribute_id;
        $this->position = $position;
        $this->is_global = $is_global;
    }


    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return int|null
     */
    public function getPartnerId(): ?int
    {
        return $this->partner_id;
    }

    /**
     * @return int
     */
    public function getAttributeId(): int
    {
        return $this->attribute_id;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function getIsGlobal(): bool
    {
        return $this->is_global;
    }


}
