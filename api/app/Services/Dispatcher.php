<?php declare(strict_types=1);

namespace App\Services;

use App\Entities\User;
use App\Exceptions\WrongDispatchableException;
use App\Interfaces\DispatchableInterface;
use GuzzleHttp\Client;

class Dispatcher
{
    protected Client $httpClient;
    protected string $usersUrl;
    protected string $financeManagerUrl;

    public function __construct(
        Client $client,
        string $usersUrl,
        string $financeManagerUrl
    )
    {
        $this->httpClient = $client;
        $this->usersUrl = $usersUrl;
        $this->financeManagerUrl = $financeManagerUrl;
    }

    public function dispatch(DispatchableInterface $dispatchable)
    {
        $result = [];

        $dispatchableClass = get_class($dispatchable);
        $dispatchableSerialized = serialize($dispatchable);

        switch ($dispatchableClass) {
            case 'App\CQRS\Queries\GetUserQuery':
                return $this->dispatchGetUserQuery($dispatchableSerialized);
            case 'App\CQRS\Queries\GetTransactionQuery':
            case 'App\CQRS\Queries\GetUserTransactionsQuery':
            case 'App\CQRS\Queries\GetUserWalletsQuery':
            case 'App\CQRS\Queries\GetWalletQuery':
                return $this->dispatchToFinancialService($dispatchableSerialized);
            case 'App\CQRS\Commands\CreateTransactionCommand':
                return $this->dispatchCreateTransactionCommand($dispatchableSerialized);
            default:
                throw new WrongDispatchableException(sprintf('Not supported dispatchable class: %s', $dispatchableClass));
        }
    }

    protected function dispatchGetUserQuery(string $serializedQuery): ?User
    {
        $result = $this->run($this->usersUrl, $serializedQuery);

        if (!isset($result['result'])) {
            return null;
        }

        return unserialize($result['result']);
    }

    protected function dispatchCreateTransactionCommand(string $serializedCommand): bool
    {
        $result = $this->run($this->financeManagerUrl, $serializedCommand);

        if (!isset($result['result'])) {
            return false;
        }

        return (bool)unserialize($result['result']);
    }


    protected function dispatchToFinancialService(string $serializedQuery)
    {
        return $this->run($this->financeManagerUrl, $serializedQuery);
    }

    private function run(string $url, string $serializedContent)
    {
        $response = $this->httpClient->post(
            $url,
            [
                'json' => ['content' => $serializedContent],
            ],
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
