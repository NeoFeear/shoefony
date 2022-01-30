<?php

namespace App\Entity\Store;

use App\Entity\Store\Color;
use App\Entity\Store\Image;
use App\Repository\Store\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="sto_product")
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionLongue;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, name="sto_image_id")
     */
    private $image;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false, name="sto_brand_id")
     */
    private $brand;

    /**
     * @ORM\ManyToMany(targetEntity=Color::class, mappedBy="products")
     * @ORM\JoinTable(name="sto_color")
     */
    private $colors;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="product", orphanRemoval=true)
     */
    private $comments;


    public function __construct() {
        $this->createdAt = new \DateTime();
        $this->colors = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }
    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }
    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }

    public function getDescriptionLongue(): ?string {
        return $this->descriptionLongue;
    }
    public function setDescriptionLongue(string $descriptionLongue): self {
        $this->descriptionLongue = $descriptionLongue;
        return $this;
    }

    public function getImage(): ?Image {
        return $this->image;
    }
    public function setImage(Image $image): self {
        $this->image = $image;
        return $this;
    }

    public function getPrice(): ?string {
        return $this->price;
    }
    public function setPrice(string $price): self {
        $this->price = $price;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTime $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getSlug(): ?string {
        return $this->slug;
    }
    public function setSlug(string $slug): self {
        $this->slug = $slug;
        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Color[]
     */
    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function addColor(Color $color): self
    {
        if (!$this->colors->contains($color)) {
            $this->colors[] = $color;
            $color->addProduct($this);
        }

        return $this;
    }

    public function removeColor(Color $color): self
    {
        if ($this->colors->removeElement($color)) {
            $color->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }
}
