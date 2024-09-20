<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Le nom du produit ne peut pas être vide.")
     * @Assert\Length(max=50, maxMessage="Le nom du produit doit faire {{limit}} caractères maximum.")
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive(message="Le prix doit être positif.")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_highlighted = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="Le prix doit être positif.")
     */
    private $XS;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="Le prix doit être positif.")
     */
    private $S;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="Le prix doit être positif.")
     */
    private $M;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="Le prix doit être positif.")
     */
    private $L;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="Le prix doit être positif.")
     */
    private $XL;

    #/**
    # * @ORM\OneToMany(targetEntity=StockSize::class, mappedBy="product", orphanRemoval: true, cascade:['persist'] )
    # */
    #private $stockSizes;

    #public function __construct()
    #{
    #    $this->stockSizes = new ArrayCollection();
    #}

    #/**
    # * @ORM\OneToMany(targetEntity=Stock::class, mappedBy="product", orphanRemoval=true)
    # */
    #private $stocks;

    #public function __construct()
    #{
    #    $this->stocks = new ArrayCollection();
    #}

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price,2,',',' ');
    }

    public function isIsHighlighted(): ?bool
    {
        return $this->is_highlighted;
    }

    public function setIsHighlighted(bool $is_highlighted): self
    {
        $this->is_highlighted = $is_highlighted;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    #/**
    # * @return Collection<int, Stock>
    # */
    #public function getStocks(): Collection
    #{
    #    return $this->stocks;
    #}

    #public function addStock(Stock $stock): self
    #{
    #    if (!$this->stocks->contains($stock)) {
    #        $this->stocks[] = $stock;
    #        $stock->setProduct($this);
    #    }
    #
    #    return $this;
    #}

    #public function removeStock(Stock $stock): self
    #{
    #    if ($this->stocks->removeElement($stock)) {
    #        // set the owning side to null (unless already changed)
    #        if ($stock->getProduct() === $this) {
    #            $stock->setProduct(null);
    #        }
    #    }

    #    return $this;
    #}

    #/**
    # * @return Collection<int, StockSize>
    # */
    #public function getStockSizes(): Collection
    #{
    #    return $this->stockSizes;
    #}

    #public function addStockSize(StockSize $stockSize): self
    #{
    #    if (!$this->stockSizes->contains($stockSize)) {
    #        $this->stockSizes[] = $stockSize;
    #        $stockSize->setProduct($this);
    #    }

    #    return $this;
    #}

    #public function removeStockSize(StockSize $stockSize): self
    #{
    #    if ($this->stockSizes->removeElement($stockSize)) {
    #        // set the owning side to null (unless already changed)
    #        if ($stockSize->getProduct() === $this) {
    #            $stockSize->setProduct(null);
    #        }
    #    }

    #    return $this;
    #}

    public function getXS(): ?int
    {
        return $this->XS;
    }

    public function setXS(int $XS): self
    {
        $this->XS = $XS;

        return $this;
    }

    public function getS(): ?int
    {
        return $this->S;
    }

    public function setS(int $S): self
    {
        $this->S = $S;

        return $this;
    }

    public function getM(): ?int
    {
        return $this->M;
    }

    public function setM(int $M): self
    {
        $this->M = $M;

        return $this;
    }

    public function getL(): ?int
    {
        return $this->L;
    }

    public function setL(int $L): self
    {
        $this->L = $L;

        return $this;
    }

    public function getXL(): ?int
    {
        return $this->XL;
    }

    public function setXL(int $XL): self
    {
        $this->XL = $XL;

        return $this;
    }
}
