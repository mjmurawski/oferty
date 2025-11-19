<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255, name: 'password_hash')]
    private ?string $passwordHash = null;

    #[ORM\Column(type: 'string', length: 20, enumType: UserRole::class)]
    private ?UserRole $role = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true, name: 'postal_code')]
    private ?string $postalCode = null;

    #[ORM\Column(type: 'datetime_immutable', name: 'created_at')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable', name: 'updated_at', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: UserProfile::class, cascade: ['persist', 'remove'])]
    private ?UserProfile $userProfile = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Offer::class)]
    private Collection $offers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Favorite::class, cascade: ['persist', 'remove'])]
    private Collection $favorites;

    #[ORM\OneToMany(mappedBy: 'reviewer', targetEntity: UserReview::class)]
    private Collection $reviewsGiven;

    #[ORM\OneToMany(mappedBy: 'reviewed', targetEntity: UserReview::class)]
    private Collection $reviewsReceived;

    #[ORM\OneToMany(mappedBy: 'reportedUser', targetEntity: Report::class)]
    private Collection $reportsReceived;

    #[ORM\OneToMany(mappedBy: 'reporter', targetEntity: Report::class)]
    private Collection $reportsMade;

    #[ORM\OneToMany(mappedBy: 'user1', targetEntity: Conversation::class)]
    private Collection $conversationsAsUser1;

    #[ORM\OneToMany(mappedBy: 'user2', targetEntity: Conversation::class)]
    private Collection $conversationsAsUser2;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Message::class)]
    private Collection $messagesSent;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: BlockedUser::class, cascade: ['persist', 'remove'])]
    private Collection $blockedUsers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Log::class)]
    private Collection $logs;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Notification::class, cascade: ['persist', 'remove'])]
    private Collection $notifications;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->reviewsGiven = new ArrayCollection();
        $this->reviewsReceived = new ArrayCollection();
        $this->reportsReceived = new ArrayCollection();
        $this->reportsMade = new ArrayCollection();
        $this->conversationsAsUser1 = new ArrayCollection();
        $this->conversationsAsUser2 = new ArrayCollection();
        $this->messagesSent = new ArrayCollection();
        $this->blockedUsers = new ArrayCollection();
        $this->logs = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->role = UserRole::USER;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): self
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function getRole(): ?UserRole
    {
        return $this->role;
    }

    public function setRole(UserRole $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;
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

    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(?UserProfile $userProfile): self
    {
        if ($userProfile === null && $this->userProfile !== null) {
            $this->userProfile->setUser(null);
        }

        if ($userProfile !== null && $userProfile->getUser() !== $this) {
            $userProfile->setUser($this);
        }

        $this->userProfile = $userProfile;
        return $this;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
            $offer->setUser($this);
        }
        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            if ($offer->getUser() === $this) {
                $offer->setUser(null);
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
            $favorite->setUser($this);
        }
        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, UserReview>
     */
    public function getReviewsGiven(): Collection
    {
        return $this->reviewsGiven;
    }

    public function addReviewsGiven(UserReview $reviewsGiven): self
    {
        if (!$this->reviewsGiven->contains($reviewsGiven)) {
            $this->reviewsGiven->add($reviewsGiven);
            $reviewsGiven->setReviewer($this);
        }
        return $this;
    }

    public function removeReviewsGiven(UserReview $reviewsGiven): self
    {
        if ($this->reviewsGiven->removeElement($reviewsGiven)) {
            if ($reviewsGiven->getReviewer() === $this) {
                $reviewsGiven->setReviewer(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, UserReview>
     */
    public function getReviewsReceived(): Collection
    {
        return $this->reviewsReceived;
    }

    public function addReviewsReceived(UserReview $reviewsReceived): self
    {
        if (!$this->reviewsReceived->contains($reviewsReceived)) {
            $this->reviewsReceived->add($reviewsReceived);
            $reviewsReceived->setReviewed($this);
        }
        return $this;
    }

    public function removeReviewsReceived(UserReview $reviewsReceived): self
    {
        if ($this->reviewsReceived->removeElement($reviewsReceived)) {
            if ($reviewsReceived->getReviewed() === $this) {
                $reviewsReceived->setReviewed(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Report>
     */
    public function getReportsReceived(): Collection
    {
        return $this->reportsReceived;
    }

    public function addReportsReceived(Report $reportsReceived): self
    {
        if (!$this->reportsReceived->contains($reportsReceived)) {
            $this->reportsReceived->add($reportsReceived);
            $reportsReceived->setReportedUser($this);
        }
        return $this;
    }

    public function removeReportsReceived(Report $reportsReceived): self
    {
        if ($this->reportsReceived->removeElement($reportsReceived)) {
            if ($reportsReceived->getReportedUser() === $this) {
                $reportsReceived->setReportedUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Report>
     */
    public function getReportsMade(): Collection
    {
        return $this->reportsMade;
    }

    public function addReportsMade(Report $reportsMade): self
    {
        if (!$this->reportsMade->contains($reportsMade)) {
            $this->reportsMade->add($reportsMade);
            $reportsMade->setReporter($this);
        }
        return $this;
    }

    public function removeReportsMade(Report $reportsMade): self
    {
        if ($this->reportsMade->removeElement($reportsMade)) {
            if ($reportsMade->getReporter() === $this) {
                $reportsMade->setReporter(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversationsAsUser1(): Collection
    {
        return $this->conversationsAsUser1;
    }

    public function addConversationsAsUser1(Conversation $conversationsAsUser1): self
    {
        if (!$this->conversationsAsUser1->contains($conversationsAsUser1)) {
            $this->conversationsAsUser1->add($conversationsAsUser1);
            $conversationsAsUser1->setUser1($this);
        }
        return $this;
    }

    public function removeConversationsAsUser1(Conversation $conversationsAsUser1): self
    {
        if ($this->conversationsAsUser1->removeElement($conversationsAsUser1)) {
            if ($conversationsAsUser1->getUser1() === $this) {
                $conversationsAsUser1->setUser1(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversationsAsUser2(): Collection
    {
        return $this->conversationsAsUser2;
    }

    public function addConversationsAsUser2(Conversation $conversationsAsUser2): self
    {
        if (!$this->conversationsAsUser2->contains($conversationsAsUser2)) {
            $this->conversationsAsUser2->add($conversationsAsUser2);
            $conversationsAsUser2->setUser2($this);
        }
        return $this;
    }

    public function removeConversationsAsUser2(Conversation $conversationsAsUser2): self
    {
        if ($this->conversationsAsUser2->removeElement($conversationsAsUser2)) {
            if ($conversationsAsUser2->getUser2() === $this) {
                $conversationsAsUser2->setUser2(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessagesSent(): Collection
    {
        return $this->messagesSent;
    }

    public function addMessagesSent(Message $messagesSent): self
    {
        if (!$this->messagesSent->contains($messagesSent)) {
            $this->messagesSent->add($messagesSent);
            $messagesSent->setSender($this);
        }
        return $this;
    }

    public function removeMessagesSent(Message $messagesSent): self
    {
        if ($this->messagesSent->removeElement($messagesSent)) {
            if ($messagesSent->getSender() === $this) {
                $messagesSent->setSender(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, BlockedUser>
     */
    public function getBlockedUsers(): Collection
    {
        return $this->blockedUsers;
    }

    public function addBlockedUser(BlockedUser $blockedUser): self
    {
        if (!$this->blockedUsers->contains($blockedUser)) {
            $this->blockedUsers->add($blockedUser);
            $blockedUser->setUser($this);
        }
        return $this;
    }

    public function removeBlockedUser(BlockedUser $blockedUser): self
    {
        if ($this->blockedUsers->removeElement($blockedUser)) {
            if ($blockedUser->getUser() === $this) {
                $blockedUser->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Log>
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Log $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs->add($log);
            $log->setUser($this);
        }
        return $this;
    }

    public function removeLog(Log $log): self
    {
        if ($this->logs->removeElement($log)) {
            if ($log->getUser() === $this) {
                $log->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications->add($notification);
            $notification->setUser($this);
        }
        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }
        return $this;
    }

    // UserInterface methods
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return [$this->role->value];
    }

    public function getPassword(): string
    {
        return $this->passwordHash;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }
}

