<?php

namespace App\Entity;

use App\Repository\ViewedWorkAppRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ViewedWorkAppRepository::class)]
#[ORM\UniqueConstraint(name: "viewed_work_app_unique", columns: ["user_id", "work_app_id"])]
#[UniqueEntity(fields: ["user_id", "work_app_id"], message: "This combination already exists.")]
class ViewedWorkApp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column()]
    private ?int $UserId = null;

    #[ORM\ManyToOne(cascade: ["remove"])]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?WorkApplication $workApp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?string
    {
        return $this->UserId;
    }

    public function setUserId(string $UserId): static
    {
        $this->UserId = $UserId;

        return $this;
    }

    public function getWorkApp(): ?WorkApplication
    {
        return $this->workAppId;
    }

    public function setWorkApp(?WorkApplication $workApp): static
    {
        $this->workApp = $workApp;

        return $this;
    }
}
