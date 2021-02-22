<?php declare(strict_types=1);

namespace App\ApiGateway\Http\Controllers;

use App\CQRS\Commands\CreateTransactionCommand;
use App\Entities\User;
use App\CQRS\Queries\GetUserWalletsQuery;
use App\Services\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;
use Ramsey\Uuid\Uuid;

class FinanceManagerController extends BaseController
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function createTransaction(Request $request)
    {
        $walletFrom = Uuid::fromString((string)$request->get('walletFrom'));
        $walletFromKey = (string)$request->get('walletFromKey');
        $walletTo = Uuid::fromString($request->get('walletTo'));
        $amount = (int)$request->get('amount');

        /** @var User $user */
        $user = Auth::user();

        $createTransactionCommand = new CreateTransactionCommand(
            Uuid::uuid4(),
            $walletFrom,
            $walletTo,
            $user->getId(),
            $walletFromKey,
            $amount,
        );

        return $this->dispatcher->dispatch($createTransactionCommand);
    }

    // Not implemented,
    public function getUserWallets(string $userId)
    {
        $userIdObject = Uuid::fromString($userId);
        $getUserWalletsQuery = new GetUserWalletsQuery($userIdObject);
        return $this->dispatcher->dispatch($getUserWalletsQuery);
    }
}
