<?php declare(strict_types=1);

namespace App\Entities;

use Ramsey\Uuid\UuidInterface;

class Transaction
{
    private UuidInterface $id;
    private UuidInterface $walletFromId;
    private UuidInterface $walletToId;
    private UuidInterface $userId;
    private int $amount;
    private int $commissionAmount;
    private \DateTime $createdAt;

    public function __construct(
        UuidInterface $id,
        UuidInterface $walletFromId,
        UuidInterface $walletToId,
        UuidInterface $userId,
        int $amount,
        int $commissionAmount,
        \DateTime $createdAt
    )
    {
        $this->id = $id;
        $this->walletFromId = $walletFromId;
        $this->walletToId = $walletToId;
        $this->userId = $userId;
        $this->amount = $amount;
        $this->commissionAmount = $commissionAmount;
        $this->createdAt = $createdAt;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getWalletFromId(): UuidInterface
    {
        return $this->walletFromId;
    }

    public function getWalletToId(): UuidInterface
    {
        return $this->walletToId;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCommissionAmount(): int
    {
        return $this->commissionAmount;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
