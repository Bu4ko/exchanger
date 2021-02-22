<?php declare(strict_types=1);

namespace App\Entities;

use Ramsey\Uuid\UuidInterface;

class Wallet
{
    private UuidInterface $id;
    private UuidInterface $userId;
    private bool $isLocked;
    private int $balance;
    private ?UuidInterface $lockedByTransaction;

    public function __construct(
        UuidInterface $id,
        UuidInterface $userId,
        bool $isLocked,
        int $balance,
        ?UuidInterface $lockedByTransaction
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->isLocked = $isLocked;
        $this->balance = $balance;
        $this->lockedByTransaction = $lockedByTransaction;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function isLocked():bool
    {
        return $this->isLocked;
    }

    public function getBalance(): int
    {
        return $this->balance;
    }

    public function lockedByTransaction(): ?UuidInterface
    {
        return $this->lockedByTransaction;
    }
}
