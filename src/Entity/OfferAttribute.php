<?php

namespace App\Entity;

use App\Repository\OfferAttributeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferAttributeRepository::class)]
#[ORM\Table(name: 'offer_attributes')]
class OfferAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Offer::class, inversedBy: 'attributes')]
    #[ORM\JoinColumn(nullable: false, name: 'offer_id', referencedColumnName: 'id')]
    private ?Offer $offer = null;

    #[ORM\ManyToOne(targetEntity: CategoryAttribute::class, inversedBy: 'offerAttributes')]
    #[ORM\JoinColumn(nullable: false, name: 'attribute_id', referencedColumnName: 'id')]
    private ?CategoryAttribute $attribute = null;

    #[ORM\Column(type: 'string', length: 500)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;
        return $this;
    }

    public function getAttribute(): ?CategoryAttribute
    {
        return $this->attribute;
    }

    public function setAttribute(?CategoryAttribute $attribute): self
    {
        $this->attribute = $attribute;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }
}

