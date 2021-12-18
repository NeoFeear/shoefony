<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez entrer votre prénom.")
     */
    private $firstName;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez entrer votre nom.")
     */
    private $lastName;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez entrer votre email.")
     * @Assert\Email(message="L'email {{ value }} n'est pas valide.")
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez entrer un message.")
     * @Assert\Length(min=25, minMessage="Votre message doit faire au moins {{ limit }} caractères.")
     */
    private $message;

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
}