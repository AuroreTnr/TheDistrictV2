<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_commande = null;


    #[ORM\Column(length: 255)]
    private ?string $nomTransporteur = null;

    #[ORM\Column]
    private ?float $prixTransporteur = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $adresseLivraison = null;

    /**
     * @var Collection<int, DetailCommande>
     */
    #[ORM\OneToMany(targetEntity: DetailCommande::class, mappedBy: 'maCommande', cascade: ['persist'])]
    private Collection $detailCommandes;

    /**
     * 
     * 1 : En attente de paiement
     * 2 : Paimement validé
     * 3 : Expédié
     */
    #[ORM\Column]
    private ?int $status = null;

    public function __construct()
    {
        $this->detailCommandes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): static
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getNomTransporteur(): ?string
    {
        return $this->nomTransporteur;
    }

    public function setNomTransporteur(string $nomTransporteur): static
    {
        $this->nomTransporteur = $nomTransporteur;

        return $this;
    }

    public function getPrixTransporteur(): ?float
    {
        return $this->prixTransporteur;
    }

    public function setPrixTransporteur(float $prixTransporteur): static
    {
        $this->prixTransporteur = $prixTransporteur;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(string $adresseLivraison): static
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    /**
     * @return Collection<int, DetailCommande>
     */
    public function getDetailCommandes(): Collection
    {
        return $this->detailCommandes;
    }

    public function addDetailCommande(DetailCommande $detailCommande): static
    {
        if (!$this->detailCommandes->contains($detailCommande)) {
            $this->detailCommandes->add($detailCommande);
            $detailCommande->setMaCommande($this);
        }

        return $this;
    }

    public function removeDetailCommande(DetailCommande $detailCommande): static
    {
        if ($this->detailCommandes->removeElement($detailCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailCommande->getMaCommande() === $this) {
                $detailCommande->setMaCommande(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }
}
