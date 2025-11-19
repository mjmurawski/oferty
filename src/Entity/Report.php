<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
#[ORM\Table(name: 'reports')]
class Report
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reportsReceived')]
    #[ORM\JoinColumn(nullable: false, name: 'reported_user_id', referencedColumnName: 'id')]
    private ?User $reportedUser = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reportsMade')]
    #[ORM\JoinColumn(nullable: false, name: 'reporter_id', referencedColumnName: 'id')]
    private ?User $reporter = null;

    #[ORM\ManyToOne(targetEntity: Offer::class, inversedBy: 'reports')]
    #[ORM\JoinColumn(nullable: true, name: 'offer_id', referencedColumnName: 'id')]
    private ?Offer $offer = null;

    #[ORM\Column(type: 'text')]
    private ?string $message = null;

    #[ORM\Column(type: 'string', length: 20, enumType: ReportStatus::class)]
    private ?ReportStatus $status = null;

    #[ORM\Column(type: 'datetime_immutable', name: 'created_at')]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->status = ReportStatus::OPEN;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportedUser(): ?User
    {
        return $this->reportedUser;
    }

    public function setReportedUser(?User $reportedUser): self
    {
        $this->reportedUser = $reportedUser;
        return $this;
    }

    public function getReporter(): ?User
    {
        return $this->reporter;
    }

    public function setReporter(?User $reporter): self
    {
        $this->reporter = $reporter;
        return $this;
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getStatus(): ?ReportStatus
    {
        return $this->status;
    }

    public function setStatus(ReportStatus $status): self
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
}

