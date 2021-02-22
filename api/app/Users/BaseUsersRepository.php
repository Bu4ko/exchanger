<?php declare(strict_types=1);

namespace App\Users;

use App\BaseRepository;

class BaseUsersRepository extends BaseRepository
{
    protected function getConnection()
    {
        return $this->getDatabaseManager()->connection('users');
    }
}
