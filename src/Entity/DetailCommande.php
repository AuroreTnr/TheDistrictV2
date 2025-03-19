<?php

namespace App\Entity;

use App\Repository\DetailCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailCommandeRepository::class)]
class DetailCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'detailCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $maCommande = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPlat = null;

    #[ORM\Column(length: 255)]
    private ?string $illustrationPlat = null;

    #[ORM\Column]
    private ?int $quantitePlat = null;

    #[ORM\Column]
    private ?float $prixPlat = null;

    #[ORM\Column]
    private ?float $tvaPlat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaCommande(): ?Commande
    {
        return $this->maCommande;
    }

    public function setMaCommande(?Commande $maCommande): static
    {
        $this->maCommande = $maCommande;

        return $this;
    }

    public function getNomPlat(): ?string
    {
        return $this->nomPlat;
    }

    public function setNomPlat(string $nomPlat): static
    {
        $this->nomPlat = $nomPlat;

        return $this;
    }

    public function getIllustrationPlat(): ?string
    {
        return $this->illustrationPlat;
    }

    public function setIllustrationPlat(string $illustrationPlat): static
    {
        $this->illustrationPlat = $illustrationPlat;

        return $this;
    }

    public function getQuantitePlat(): ?int
    {
        return $this->quantitePlat;
    }

    public function setQuantitePlat(int $quantitePlat): static
    {
        $this->quantitePlat = $quantitePlat;

        return $this;
    }

    public function getPrixPlat(): ?float
    {
        return $this->prixPlat;
    }

    public function setPrixPlat(float $prixPlat): static
    {
        $this->prixPlat = $prixPlat;

        return $this;
    }

    public function getTvaPlat(): ?float
    {
        return $this->tvaPlat;
    }

    public function setTvaPlat(float $tvaPlat): static
    {
        $this->tvaPlat = $tvaPlat;

        return $this;
    }
}
