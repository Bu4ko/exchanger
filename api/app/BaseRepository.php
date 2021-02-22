<?php declare(strict_types=1);

namespace App;

use Illuminate\Database\DatabaseManager;

class BaseRepository
{
    protected DatabaseManager $databaseManager;

    public function __construct()
    {
        $this->databaseManager = app('db');
    }

    public function getDatabaseManager(): DatabaseManager
    {
        return $this->databaseManager;
    }
}
