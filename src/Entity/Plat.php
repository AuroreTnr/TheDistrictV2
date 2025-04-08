<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PlatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
#[ApiResource(
    operations: [
            new Get(normalizationContext: ['groups' => 'plat:read']),
            new GetCollection(normalizationContext: ['groups' => 'plat:read'])
    ]
)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['plat:read' ,'comment:list', 'comment:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['plat:read' ,'comment:list', 'comment:item'])]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['plat:read' ,'comment:list', 'comment:item'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['plat:read' ,'comment:list', 'comment:item'])]
    private ?float $prix = null;

    #[ORM\Column]
    #[Groups(['plat:read' ,'comment:list', 'comment:item'])]
    private ?float $tva = null;

    #[ORM\Column(length: 225)]
    #[Groups(['plat:read' ,'comment:list', 'comment:item'])]
    private ?string $image = null;

    #[ORM\Column]
    #[Groups(['plat:read' ,'comment:list', 'comment:item'])]
    private ?bool $active = null;

    #[ORM\ManyToOne(inversedBy: 'plats')]
    #[Groups(['plat:read' ,'comment:list', 'comment:item'])]
    private ?Categorie $categorie = null;


    #[ORM\Column(length: 255)]
    #[Groups(['plat:read' ,'comment:list', 'comment:item'])]
    private ?string $slug = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPriceWt()
    {
        $coeff = 1 + ($this->tva/100);

        return number_format($coeff * $this->prix, 2, '.', '');
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): static
    {
        $this->tva = $tva;

        return $this;
    }



}