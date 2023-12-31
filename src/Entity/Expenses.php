<?php

namespace App\Entity;

use App\Repository\ExpensesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpensesRepository::class)]
class Expenses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'expenses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?int $value = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at;

    #[ORM\ManyToOne(inversedBy: 'expenses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tricounts $tricount = null;

    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'concerned_expenses')]
    private Collection $concerned_users;

    public function __construct()
    {
        $this->concerned_users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTricount(): ?Tricounts
    {
        return $this->tricount;
    }

    public function setTricount(?Tricounts $tricount): static
    {
        $this->tricount = $tricount;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getConcernedUsers(): Collection
    {
        return $this->concerned_users;
    }

    public function addConcernedUser(Users $concernedUser): static
    {
        if (!$this->concerned_users->contains($concernedUser)) {
            $this->concerned_users->add($concernedUser);
        }

        return $this;
    }

    public function removeConcernedUser(Users $concernedUser): static
    {
        $this->concerned_users->removeElement($concernedUser);

        return $this;
    }
}
