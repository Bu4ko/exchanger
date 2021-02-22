<?php declare(strict_types=1);

namespace App\FinanceManager\Repositories;

use App\Entities\Wallet;
use App\FinanceManager\BaseFinanceManagerRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class WalletsRepository extends BaseFinanceManagerRepository
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    public function getWalletById(UuidInterface $walletId): ?Wallet
    {
        $data = $this->getConnection()->select("SELECT * FROM wallets WHERE id = ?", [$walletId]);

        if (isset($data[0])) {
            return $this->mapDataToWallet($data[0]);
        }

        return null;
    }

    public function getAdminWallet(): ?Wallet
    {
        $walletId = env('ADMIN_WALLET_ID');
        return $this->getWalletById(Uuid::fromString($walletId));
    }

    public function decreaseWalletAmount(Wallet $wallet, int $amountToMinus): int
    {
        return $this->getConnection()->update(
            'UPDATE wallets SET balance = ? WHERE id = ?',
            [$wallet->getBalance() - $amountToMinus, $wallet->getId()]
        );
    }

    public function increaseWalletAmount(Wallet $wallet, int $amountToAdd): int
    {
        return $this->getConnection()->update(
            'UPDATE wallets SET balance = ? WHERE id = ?',
            [$wallet->getBalance() + $amountToAdd, $wallet->getId()]
        );
    }

    public function lockWalletsForTransfer(Wallet $walletFrom, Wallet $walletTo, UuidInterface $transactionId): int
    {
        return $this->getConnection()->update(
            'UPDATE wallets SET is_locked = ?, locked_by_transaction = ?, updated_at = ? WHERE id = ? OR id = ?',
            [true, $transactionId, date(self::DATE_FORMAT), $walletFrom->getId(), $walletTo->getId()]
        );
    }

    public function unlockWalletsAfterTransfer(Wallet $walletFrom, Wallet $walletTo): int
    {
        return $this->getConnection()->update(
            'UPDATE wallets SET is_locked = ?, locked_by_transaction = ?, updated_at = ? WHERE id = ? OR id = ?',
            [false, null, date(self::DATE_FORMAT), $walletFrom->getId(), $walletTo->getId()]
        );
    }

    public function isKeyForWallet(Wallet $wallet, string $key): bool
    {
        $data = $this->getConnection()
            ->select("SELECT * FROM wallets WHERE id = ? and wallet_key = ?", [$wallet->getId(), $key]);

        if (isset($data[0])) {
            return true;
        }

        return false;
    }

    public function isWalletLocked(Wallet $wallet): bool
    {
        $data = $this->getConnection()
            ->select("SELECT * FROM wallets WHERE id = ?", [$wallet->getId()]);

        if (isset($data[0])) {
            return (bool)$data[0]->is_locked;
        }

        return false;
    }

    private function mapDataToWallet(\stdClass $data): Wallet
    {
        return new Wallet(
            Uuid::fromString($data->id),
            Uuid::fromString($data->user_id),
            (bool)$data->is_locked,
            (int)$data->balance,
            $data->locked_by_transaction ? Uuid::fromString($data->locked_by_transaction) : null
        );
    }
}
