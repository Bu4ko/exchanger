<?php declare(strict_types=1);

namespace App\Entities;

use Ramsey\Uuid\UuidInterface;

class User
{
    private UuidInterface $id;
    private string $name;
    private string $surname;
    private string $email;
    private bool $isActive;
    private string $address;

    public function __construct(
        UuidInterface $id,
        string $name,
        string $surname,
        string $email,
        bool $isActive,
        string $address
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->isActive = $isActive;
        $this->address = $address;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}
