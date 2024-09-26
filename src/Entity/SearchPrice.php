<?php

namespace App\Entity;

use App\Repository\SearchPriceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SearchPriceRepository::class)
 */
class SearchPrice
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
     * @ORM\Column(type="integer")
     */
    private $minLimit;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxLimit;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderBy;

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

    public function getMinLimit(): ?int
    {
        return $this->minLimit;
    }

    public function setMinLimit(int $minLimit): self
    {
        $this->minLimit = $minLimit;

        return $this;
    }

    public function getMaxLimit(): ?int
    {
        return $this->maxLimit;
    }

    public function setMaxLimit(int $maxLimit): self
    {
        $this->maxLimit = $maxLimit;

        return $this;
    }

    public function getOrderBy(): ?int
    {
        return $this->orderBy;
    }

    public function setOrderBy(int $orderBy): self
    {
        $this->orderBy = $orderBy;

        return $this;
    }
}
