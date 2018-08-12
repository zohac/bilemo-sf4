<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * A User.
 *
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email déjà utilisé")
 * @UniqueEntity(fields="username", message="Pseudo déjà utilisé.")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Groups({"user"})
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"user"})
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"user"})
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Groups({"user"})
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\Length(max=4096)
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z0-9]{6,}$/",
     *      message="Le mot de passe doit comporter au moins 6 caractères, minuscule, majuscule et numérique."
     * )
     *
     * @Groups({"user"})
     *
     * @Assert\NotBlank(groups={"Create"})
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @var string
     */
    private $salt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials()
    {
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }
}
