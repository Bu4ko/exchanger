<?php declare(strict_types=1);

namespace App\FinanceManager\Validators;

use App\Entities\Wallet;
use App\FinanceManager\Exceptions\CreateTransactionValidatorException;
use App\FinanceManager\Repositories\WalletsRepository;

class CreateTransactionValidator
{
    private Wallet $walletFrom;
    private Wallet $walletTo;
    private string $walletKey;
    private int $transferAmount;

    public function __construct(
        Wallet $walletFrom,
        Wallet $walletTo,
        string $walletKey,
        int $transferAmount
    ) {
        $this->walletFrom = $walletFrom;
        $this->walletTo = $walletTo;
        $this->walletKey = $walletKey;
        $this->transferAmount = $transferAmount;
    }

    public function getWalletFrom(): Wallet
    {
        return $this->walletFrom;
    }

    public function getWalletTo(): Wallet
    {
        return $this->walletTo;
    }

    public function getWalletKey(): string
    {
        return $this->walletKey;
    }

    public function getTransferAmount(): int
    {
        return $this->transferAmount;
    }

    /**
     * @return bool
     * @throws CreateTransactionValidatorException
     */
    public function validate(): bool
    {
        if ($this->getWalletFrom()->getBalance() < $this->getTransferAmount()) {
            throw new CreateTransactionValidatorException('Low amount in wallet from');
        }

        $walletRepository = app(WalletsRepository::class);

        if (!$walletRepository->isKeyForWallet($this->getWalletFrom(), $this->getWalletKey())) {
            throw new CreateTransactionValidatorException('Invalid key for wallet from');
        }

        if ($walletRepository->isWalletLocked($this->getWalletFrom())) {
            throw new CreateTransactionValidatorException('Wallet from is locked');
        }

        if ($walletRepository->isWalletLocked($this->getWalletTo())) {
            throw new CreateTransactionValidatorException('Wallet to is locked');
        }

        return true;
    }
}
