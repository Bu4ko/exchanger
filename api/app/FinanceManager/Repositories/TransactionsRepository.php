<?php declare(strict_types=1);

namespace App\FinanceManager\Repositories;

use App\Entities\Transaction;
use App\Entities\Wallet;
use App\FinanceManager\BaseFinanceManagerRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class TransactionsRepository extends BaseFinanceManagerRepository
{
    public function getTransactionById(UuidInterface $transactionId): ?Transaction
    {
        $transaction = null;
        $data = $this->getConnection()->select("SELECT * FROM transactions WHERE id = ?", [$transactionId]);

        if (!empty($data[0])) {
            $transaction = $this->mapDataToTransaction($data[0]);
        }

        return $transaction;
    }

    public function getUserTransactions(UuidInterface $userId): Collection
    {
        $data = $this->getConnection()
            ->select("SELECT * FROM transactions WHERE user_id = ?", [$userId]);

        $transactions = collect();

        foreach ($data as $dataItem) {
            $transaction = $this->mapDataToTransaction($dataItem);
            $transactions->push($transaction);
        }

        return $transactions;
    }

    public function createTransaction(
        UuidInterface $transactionId,
        Wallet $walletFrom,
        Wallet $walletTo,
        Wallet $adminWallet,
        UuidInterface $userId,
        int $amountToAdd,
        int $amount,
        int $commissionAmount
    ): bool {
        DB::beginTransaction();
        try {
            $walletsRepository = app(WalletsRepository::class);
            $walletsRepository->decreaseWalletAmount($walletFrom, $amount);
            $walletsRepository->increaseWalletAmount($walletTo, $amountToAdd);
            $walletsRepository->increaseWalletAmount($adminWallet, $commissionAmount);

            $this->getConnection()->insert(
                'INSERT INTO transactions (id, wallet_from_id, wallet_to_id, user_id, amount, commission_amount)
                    VALUES (?, ?, ?, ?, ?, ?)',
                [$transactionId, $walletFrom->getId(), $walletTo->getId(), $userId, $amount, $commissionAmount],
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        DB::commit();

        return true;
    }

    private function mapDataToTransaction(\stdClass $data): Transaction
    {
        return new Transaction(
            Uuid::fromString($data->id),
            Uuid::fromString($data->wallet_from_id),
            Uuid::fromString($data->wallet_to_id),
            Uuid::fromString($data->user_id),
            (int)$data->amount,
            (int)$data->commission_amount,
            (new \DateTime)->setTimestamp($data->created_at)
        );
    }
}
