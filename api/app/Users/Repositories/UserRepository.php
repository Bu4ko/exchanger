<?php declare(strict_types=1);

namespace App\Users\Repositories;

use App\Entities\User;
use App\Users\BaseUsersRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserRepository extends BaseUsersRepository
{
    public function getUserByIdAndToken(UuidInterface $userId, string $token): ?User
    {
        $user = null;
        $data = $this->getConnection()->select(
            "SELECT * FROM users WHERE id = ? AND token = ?",
            [$userId, $token]
        );

        if (!empty($data[0])) {
            $user = $this->mapDataToUser($data[0]);
        }

        return $user;
    }

    private function mapDataToUser(\stdClass $data): User
    {
        return new User(
            Uuid::fromString((string)$data->id),
            (string)$data->name,
            (string)$data->surname,
            (string)$data->email,
            (bool)$data->is_active,
            (string)$data->address
        );
    }
}
