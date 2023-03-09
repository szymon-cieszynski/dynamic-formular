<?php

namespace App\Entity;

use App\Repository\TextFieldRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TextFieldRepository::class)]
class TextField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $textField = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextField(): ?string
    {
        return $this->textField;
    }

    public function setTextField(string $textField): self
    {
        $this->textField = $textField;

        return $this;
    }
}
