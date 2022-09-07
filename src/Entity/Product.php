<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $src;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="products")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Panic::class, mappedBy="produit")
     */
    private $panics;

    public function __construct()
    {
        $this->panics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    public function getCategorie(): ?categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Panic[]
     */
    public function getPanics(): Collection
    {
        return $this->panics;
    }

    public function addPanic(Panic $panic): self
    {
        if (!$this->panics->contains($panic)) {
            $this->panics[] = $panic;
            $panic->setProduit($this);
        }

        return $this;
    }

    public function removePanic(Panic $panic): self
    {
        if ($this->panics->removeElement($panic)) {
            // set the owning side to null (unless already changed)
            if ($panic->getProduit() === $this) {
                $panic->setProduit(null);
            }
        }

        return $this;
    }
}
