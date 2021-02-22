<?php declare(strict_types=1);

namespace App\CQRS\Queries;

use App\Interfaces\DispatchableInterface;
use Ramsey\Uuid\UuidInterface;

class GetUserQuery implements DispatchableInterface
{
    private UuidInterface $userId;
    private string $token;

    public function __construct(UuidInterface $userId, string $token)
    {
        $this->userId = $userId;
        $this->token = $token;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getUserToken(): string
    {
        return $this->token;
    }
}
