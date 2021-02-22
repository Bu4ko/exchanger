<?php declare(strict_types=1);

namespace App\FinanceManager;

use App\BaseRepository;

class BaseFinanceManagerRepository extends BaseRepository
{
    protected function getConnection()
    {
        return $this->getDatabaseManager()->connection('finance');
    }
}
