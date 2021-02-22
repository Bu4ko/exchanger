<?php declare(strict_types=1);

namespace App\Users\CQRS\QueryHandlers;

use App\Interfaces\HandlerInterface;
use App\CQRS\HandlerResult;
use App\Interfaces\HandlerResultInterface;
use App\Interfaces\DispatchableInterface;
use App\CQRS\Queries\GetUserQuery;
use App\Users\Repositories\UserRepository;

class GetUserQueryHandler implements HandlerInterface
{
    public function handle(DispatchableInterface $dispatchable): HandlerResultInterface
    {
        /** @var GetUserQuery $dispatchable */
        if (!($dispatchable instanceof GetUserQuery)) {
            throw new \Exception('Wrong object passed to handler');
        }

        $usersRepository = app(UserRepository::class);
        $user = $usersRepository->getUserByIdAndToken($dispatchable->getUserId(), $dispatchable->getUserToken());

        if (!$user) {
            return new HandlerResult(['exception' => 'Wallet not found']);
        }

        return new HandlerResult(['result' => serialize($user)]);
    }
}
