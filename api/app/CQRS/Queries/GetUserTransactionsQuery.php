<?php declare(strict_types=1);

namespace App\CQRS\Queries;

use App\Interfaces\QueryInterface;

class GetUserTransactionsQuery implements QueryInterface
{
    private string $transactionId;

    public function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }
}
