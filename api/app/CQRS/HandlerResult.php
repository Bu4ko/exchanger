<?php declare(strict_types=1);

namespace App\CQRS;

use App\Interfaces\HandlerResultInterface;

class HandlerResult implements HandlerResultInterface
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
