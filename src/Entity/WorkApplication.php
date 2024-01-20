<?php

namespace App\Entity;

use App\Repository\WorkApplicationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: WorkApplicationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class WorkApplication
{
    const LEVEL_JUNIOR = 'junior';
    const LEVEL_REGULAR = 'regular';
    const LEVEL_SENIOR = 'senior';
    const SALARY_REGULAR_START = 5000;
    const SALARY_SENIOR_START = 10000;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['workAppList', 'oneWorkApp'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['workAppList', 'oneWorkApp'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 70)]
    #[Groups(['workAppList', 'oneWorkApp'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 50)]
    #[Groups(['oneWorkApp'])]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    #[Groups(['oneWorkApp'])]
    private ?string $phone = null;

    #[ORM\Column]
    #[Groups(['oneWorkApp'])]
    private ?int $salary = null;

    #[ORM\Column(length: 150)]
    #[Groups(['workAppList', 'oneWorkApp'])]
    private ?string $position = null;

    #[ORM\Column(length: 10)]
    #[Groups(['workAppList', 'oneWorkApp'])]
    private ?string $level = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    #[Groups(['oneWorkApp'])]
    public function getDateCreated():string
    {
        return $this->createdAt->format("Y-m-d h:i:s");
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setLevelAtValue(): void
    {
        $level = self::LEVEL_SENIOR;
        if ($this->getSalary() < self::SALARY_SENIOR_START) {
            $level = self::LEVEL_REGULAR;
        }
        if ($this->getSalary() < self::SALARY_REGULAR_START) {
            $level = self::LEVEL_JUNIOR;
        }
        $this->level = $level;
    }
}
