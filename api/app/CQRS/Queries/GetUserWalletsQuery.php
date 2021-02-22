<?php declare(strict_types=1);

namespace App\CQRS\Queries;

use App\Interfaces\QueryInterface;
use Ramsey\Uuid\UuidInterface;

class GetUserWalletsQuery implements QueryInterface
{
    private UuidInterface $userId;

    public function __construct(UuidInterface $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }
}
