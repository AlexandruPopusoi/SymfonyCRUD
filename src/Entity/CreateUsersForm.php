<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUsersForm
{
    #[Assert\NotBlank]
    protected $Name;

    #[Assert\NotBlank]
    protected $Surname;

    #[Assert\NotBlank]
    protected $Username;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    protected $Email;

    #[Assert\NotBlank]
    #[Assert\Type(\DateTime::class)]
    protected $BirthDate;

    #[Assert\NotBlank]
    protected $Password;

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $Name): void
    {
        $this->Name = $Name;
    }

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): void
    {
        $this->Surname = $Surname;
    }

    public function getUsername(): string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): void
    {
        $this->Username = $Username;
    }

    public function getEmail(): string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): void
    {
        $this->Email = $Email;
    }

    public function getPassword(): string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): void
    {
        $this->Password = $Password;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->BirthDate;
    }

    public function setBirthDate(?\DateTime $BirthDate): void
    {
        $this->BirthDate = $BirthDate;
    }
}