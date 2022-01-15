<?php

namespace App\Entity;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @ORM\Table(name="app_contact")
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer votre prénom.")
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer votre nom.")
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer votre email.")
     * @Assert\Email(message="L'email {{ value }} n'est pas valide.")
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez entrer un message.")
     * @Assert\Length(min=25, minMessage="Votre message doit faire au moins {{ limit }} caractères.")
     */
    private $message;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    // ID
    public function getId(): ?int {
        return $this->id;
    }

    // FirstName
    public function getFirstName(): ?string {
        return $this->firstName;
    }
    public function setFirstName(string $firstName): self {
        $this->firstName = $firstName;
        return $this;
    }

    // LastName
    public function getLastName(): ?string {
        return $this->lastName;
    }
    public function setLastName(string $lastName): self {
        $this->lastName = $lastName;
        return $this;
    }

    // Email
    public function getEmail(): ?string {
        return $this->email;
    }
    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    // Message
    public function getMessage(): ?string {
        return $this->message;
    }
    public function setMessage(string $message): self {
        $this->message = $message;
        return $this;
    }

    // CreatedAt
    public function getCreatedAt(): ?\DateTime {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTime $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }
}