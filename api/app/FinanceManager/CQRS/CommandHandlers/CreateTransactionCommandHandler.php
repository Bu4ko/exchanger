<?php declare(strict_types=1);

namespace App\FinanceManager\CQRS\CommandHandlers;

use App\CQRS\Commands\CreateTransactionCommand;
use App\Interfaces\HandlerInterface;
use App\CQRS\HandlerResult;
use App\Interfaces\HandlerResultInterface;
use App\FinanceManager\Exceptions\CreateTransactionValidatorException;
use App\FinanceManager\Repositories\TransactionsRepository;
use App\FinanceManager\Repositories\WalletsRepository;
use App\FinanceManager\Validators\CreateTransactionValidator;
use App\Interfaces\DispatchableInterface;

class CreateTransactionCommandHandler implements HandlerInterface
{
    public function handle(DispatchableInterface $dispatchable): HandlerResultInterface
    {
        /** @var CreateTransactionCommand $dispatchable */
        if (!($dispatchable instanceof CreateTransactionCommand)) {
            throw new \Exception('Wrong object passed to handler');
        }

        // This may be done with query, just simplifying here as it's one service
        $walletsRepository = app(WalletsRepository::class);
        $walletFrom = $walletsRepository->getWalletById($dispatchable->getWalletFromId());
        $walletTo = $walletsRepository->getWalletById($dispatchable->getWalletToId());
        $adminWallet = $walletsRepository->getAdminWallet();
        $walletKey = $dispatchable->getWalletFromKey();
        $transactionAmount = $dispatchable->getTransactionAmount();
        $transactionId = $dispatchable->getTransactionId();
        $userId = $dispatchable->getUserId();

        if (!$walletFrom || !$walletTo || !$adminWallet) {
            return new HandlerResult(['exception' => 'Wallet not found']);
        }

        $commissionPercent = (int)env('TRANSACTION_COMMISSION_PERCENT');
        $commissionAmount = (int)ceil($transactionAmount * $commissionPercent / 100);
        $amountToAdd = $transactionAmount - $commissionAmount;

        $validator = new CreateTransactionValidator(
            $walletFrom,
            $walletTo,
            $walletKey,
            $transactionAmount
        );

        try {
            $validator->validate();
        } catch (CreateTransactionValidatorException $e) {
            return new HandlerResult(['exception' => $e->getMessage()]);
        }

        $walletsRepository->lockWalletsForTransfer($walletFrom, $walletTo, $transactionId);

        try {
            $transactionRepository = app(TransactionsRepository::class);

            $result = $transactionRepository->createTransaction(
                $transactionId,
                $walletFrom,
                $walletTo,
                $adminWallet,
                $userId,
                $amountToAdd,
                $transactionAmount,
                $commissionAmount
            );
        } catch (\Exception $e) {
            $walletsRepository->unlockWalletsAfterTransfer($walletFrom, $walletTo);
            return new HandlerResult(['exception' => $e->getMessage()]);
        }

        $walletsRepository->unlockWalletsAfterTransfer($walletFrom, $walletTo);

        return new HandlerResult(['result' => serialize($result)]);
    }
}
