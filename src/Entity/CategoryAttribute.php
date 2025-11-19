<?php

namespace App\Entity;

use App\Repository\CategoryAttributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryAttributeRepository::class)]
#[ORM\Table(name: 'category_attributes')]
class CategoryAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'categoryAttributes')]
    #[ORM\JoinColumn(nullable: false, name: 'category_id', referencedColumnName: 'id')]
    private ?Category $category = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 20, enumType: AttributeType::class)]
    private ?AttributeType $type = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $options = null;

    #[ORM\OneToMany(mappedBy: 'attribute', targetEntity: OfferAttribute::class, cascade: ['persist', 'remove'])]
    private Collection $offerAttributes;

    public function __construct()
    {
        $this->offerAttributes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ?AttributeType
    {
        return $this->type;
    }

    public function setType(AttributeType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): self
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return Collection<int, OfferAttribute>
     */
    public function getOfferAttributes(): Collection
    {
        return $this->offerAttributes;
    }

    public function addOfferAttribute(OfferAttribute $offerAttribute): self
    {
        if (!$this->offerAttributes->contains($offerAttribute)) {
            $this->offerAttributes->add($offerAttribute);
            $offerAttribute->setAttribute($this);
        }
        return $this;
    }

    public function removeOfferAttribute(OfferAttribute $offerAttribute): self
    {
        if ($this->offerAttributes->removeElement($offerAttribute)) {
            if ($offerAttribute->getAttribute() === $this) {
                $offerAttribute->setAttribute(null);
            }
        }
        return $this;
    }
}

