<?php declare(strict_types=1);

namespace App\Users\CQRS;

use App\Exceptions\WrongDispatchableException;
use App\Interfaces\DispatchableInterface;
use App\Interfaces\HandlerInterface;
use App\Users\CQRS\QueryHandlers\GetUserQueryHandler;

/**
 * Responsible for dispatching Commands/Queries to appropriate handlers
 *
 * Class Resolver
 * @package App\Users\CQRS
 */
class Resolver
{
    public function resolve(DispatchableInterface $entity): HandlerInterface
    {
        $entityClass = get_class($entity);

        switch ($entityClass) {
            case 'App\CQRS\Queries\GetUserQuery':
                return new GetUserQueryHandler();
            default:
                throw new WrongDispatchableException(sprintf('Not supported dispatchable class: %s', $entityClass));

        }
    }
}
