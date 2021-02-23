<?php declare(strict_types=1);

namespace App\FinanceManager\CQRS;

use App\Exceptions\WrongDispatchableException;
use App\FinanceManager\CQRS\CommandHandlers\CreateTransactionCommandHandler;
use App\Interfaces\DispatchableInterface;
use App\Interfaces\HandlerInterface;

/**
 * Responsible for dispatching Commands/Queries to appropriate handlers
 *
 * Class Resolver
 * @package App\FinanceManager\CQRS
 */
class Resolver
{
    public function resolve(DispatchableInterface $entity): HandlerInterface
    {
        $entityClass = get_class($entity);

        switch ($entityClass) {
            case 'App\CQRS\Commands\CreateTransactionCommand':
                return new CreateTransactionCommandHandler();
            default:
                throw new WrongDispatchableException(sprintf('Not supported dispatchable class: %s', $entityClass));

        }
    }
}
