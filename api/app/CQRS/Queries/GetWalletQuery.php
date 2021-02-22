<?php declare(strict_types=1);

namespace App\CQRS\Queries;

use App\Interfaces\QueryInterface;

class GetWalletQuery implements QueryInterface
{
    private string $walletId;

    public function __construct(string $walletId)
    {
        $this->walletId = $walletId;
    }

    public function getWalletId(): string
    {
        return $this->walletId;
    }
}
