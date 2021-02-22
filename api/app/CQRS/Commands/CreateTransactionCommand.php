<?php declare(strict_types=1);

namespace App\CQRS\Commands;

use App\Interfaces\CommandInterface;
use Ramsey\Uuid\UuidInterface;

class CreateTransactionCommand implements CommandInterface
{
    private UuidInterface $transactionId;
    private UuidInterface $walletFromId;
    private UuidInterface $walletToId;
    private UuidInterface $userId;
    private string $walletFromKey;
    private int $transactionAmount;

    public function __construct(
        UuidInterface $transactionId,
        UuidInterface $walletFromId,
        UuidInterface $walletToId,
        UuidInterface $userId,
        string $walletFromKey,
        int $transactionAmount
    ) {
        $this->transactionId = $transactionId;
        $this->walletFromId = $walletFromId;
        $this->walletToId = $walletToId;
        $this->userId = $userId;
        $this->walletFromKey = $walletFromKey;
        $this->transactionAmount = $transactionAmount;
    }

    public function getTransactionId(): UuidInterface
    {
        return $this->transactionId;
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

    public function getWalletFromKey(): string
    {
        return $this->walletFromKey;
    }

    public function getTransactionAmount(): int
    {
        return $this->transactionAmount;
    }
}
