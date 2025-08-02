<?php

namespace Product\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;


    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product')]
    private Collection $images;


    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favorites')]
    private Collection $favoritedBy;

    public function __construct(

        #[ORM\Column(type: 'string')]
        private string $name,

        #[ORM\Column(type: 'string')]
        private string $category
    ) {
        $this->images = new ArrayCollection();
        $this->favoritedBy = new ArrayCollection();
    }

    public function isFavoriteForUser(UserInterface $user): bool
    {
        return $this->favoritedBy->contains($user);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return ProductImage[]
     */
    public function getImages(): array
    {
        return $this->images->toArray();
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return User[]
     */
    public function getFavoritedBy(): array
    {
        return $this->favoritedBy->toArray();
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
