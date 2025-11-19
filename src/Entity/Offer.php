<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
#[ORM\Table(name: 'offers')]
#[ORM\HasLifecycleCallbacks]
class Offer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false, name: 'user_id', referencedColumnName: 'id')]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false, name: 'category_id', referencedColumnName: 'id')]
    private ?Category $category = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $price = null;

    #[ORM\Column(type: 'boolean', name: 'price_negotiable')]
    private bool $priceNegotiable = false;

    #[ORM\Column(type: 'boolean')]
    private bool $free = false;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $region = null;

    #[ORM\Column(type: 'string', length: 20, enumType: OfferStatus::class)]
    private ?OfferStatus $status = null;

    #[ORM\Column(type: 'datetime_immutable', name: 'created_at')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable', name: 'updated_at', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: OfferPhoto::class, cascade: ['persist', 'remove'])]
    private Collection $photos;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: OfferVideo::class, cascade: ['persist', 'remove'])]
    private Collection $videos;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: OfferAttribute::class, cascade: ['persist', 'remove'])]
    private Collection $attributes;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: Favorite::class)]
    private Collection $favorites;

    #[ORM\OneToMany(mappedBy: 'offer', targetEntity: Report::class)]
    private Collection $reports;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->reports = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->status = OfferStatus::ACTIVE;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function isPriceNegotiable(): bool
    {
        return $this->priceNegotiable;
    }

    public function setPriceNegotiable(bool $priceNegotiable): self
    {
        $this->priceNegotiable = $priceNegotiable;
        return $this;
    }

    public function isFree(): bool
    {
        return $this->free;
    }

    public function setFree(bool $free): self
    {
        $this->free = $free;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;
        return $this;
    }

    public function getStatus(): ?OfferStatus
    {
        return $this->status;
    }

    public function setStatus(OfferStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Collection<int, OfferPhoto>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(OfferPhoto $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setOffer($this);
        }
        return $this;
    }

    public function removePhoto(OfferPhoto $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            if ($photo->getOffer() === $this) {
                $photo->setOffer(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, OfferVideo>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(OfferVideo $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setOffer($this);
        }
        return $this;
    }

    public function removeVideo(OfferVideo $video): self
    {
        if ($this->videos->removeElement($video)) {
            if ($video->getOffer() === $this) {
                $video->setOffer(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, OfferAttribute>
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(OfferAttribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes->add($attribute);
            $attribute->setOffer($this);
        }
        return $this;
    }

    public function removeAttribute(OfferAttribute $attribute): self
    {
        if ($this->attributes->removeElement($attribute)) {
            if ($attribute->getOffer() === $this) {
                $attribute->setOffer(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setOffer($this);
        }
        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            if ($favorite->getOffer() === $this) {
                $favorite->setOffer(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Report>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): self
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setOffer($this);
        }
        return $this;
    }

    public function removeReport(Report $report): self
    {
        if ($this->reports->removeElement($report)) {
            if ($report->getOffer() === $this) {
                $report->setOffer(null);
            }
        }
        return $this;
    }
}

