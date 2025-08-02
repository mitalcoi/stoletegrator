<?php

namespace Product\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'favoritedBy')]
    #[ORM\JoinTable(name: 'user_favorites')]
    private Collection $favorites;
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $password;

    public function __construct(
        #[ORM\Column(type: 'string', unique: true)]
        private string $username
    ) {
        $this->favorites = new ArrayCollection();
    }

    /**
     * @return Product[]
     */
    public function getFavorites(): array
    {
        return $this->favorites->toArray();
    }

    public function toggleFavorite(Product $product): void
    {
        if ($this->favorites->contains($product)) {
            $this->favorites->removeElement($product);
        } else {
            $this->favorites->add($product);
        }
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

}
