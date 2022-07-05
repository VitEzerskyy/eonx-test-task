<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Customer\ListController;
use App\Controller\Customer\ShowController;
use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ApiResource(
    collectionOperations: [
    'get' => [
        'method' => 'GET',
        'path' => '/customers',
        'controller' => ListController::class,
        'normalization_context' => ['groups' => ['list']],
    ],
],
    itemOperations: [
    'get' => [
        'method' => 'GET',
        'path' => '/customers/{id}',
        'controller' => ShowController::class,
        'normalization_context' => ['groups' => ['show']],
    ],
],
    paginationEnabled: false,
)]
class Customer
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    #[Groups(["list", "show"])]
    private ?int $id = null;

    #[ORM\Column(type: "string", nullable: false)]
    #[Assert\NotBlank]
    private string $firstName = '';

    #[ORM\Column(type: "string", nullable: false)]
    #[Assert\NotBlank]
    private string $lastName = '';

    #[ORM\Column(type: "string", nullable: false)]
    #[Assert\NotBlank, Assert\Email]
    #[Groups(["list", "show"])]
    private string $email = '';

    #[ORM\Column(type: "string", nullable: false)]
    #[Assert\NotBlank]
    #[Groups(["list", "show"])]
    private string $country = '';

    #[ORM\Column(type: "string", nullable: false)]
    #[Assert\NotBlank]
    #[Groups("show")]
    private string $username = '';

    #[ORM\Column(type: "string", nullable: false)]
    #[Assert\NotBlank, Assert\Choice(choices: ['male', 'female'])]
    #[Groups("show")]
    private string $gender = '';

    #[ORM\Column(type: "string", nullable: false)]
    #[Assert\NotBlank]
    #[Groups("show")]
    private string $city = '';

    #[ORM\Column(type: "string", nullable: false)]
    #[Assert\NotBlank]
    #[Groups("show")]
    private string $phone = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    #[Groups(["list", "show"])]
    public function getFullName(): string
    {
        return $this->getFirstName().' '.$this->getLastName();
    }
}