<?php declare(strict_types=1);

use App\FinanceManager\Repositories\WalletsRepository;
use App\FinanceManager\Validators\CreateTransactionValidator;
use Ramsey\Uuid\Uuid;
use App\Entities\Wallet;
use App\FinanceManager\Exceptions\CreateTransactionValidatorException;

class CreateTransactionValidatorTest extends TestCase
{
    public function testValidatorSuccess()
    {
        $mock = $this->createMock(WalletsRepository::class);
        $mock->method('isKeyForWallet')->willReturn(true);
        $mock->method('isWalletLocked')->willReturn(false);
        $mock->method('isKeyForWallet')->willReturn(true);
        $this->app[WalletsRepository::class] = $mock;
        $walletFrom = new Wallet(Uuid::uuid4(), Uuid::uuid4(), false, 50000, null);
        $walletTo = new Wallet(Uuid::uuid4(), Uuid::uuid4(), false, 50001, null);

        $validator = new CreateTransactionValidator($walletFrom, $walletTo, 'fGDSg', 50);
        self::assertTrue($validator->validate());
    }

    public function testValidatorLocked()
    {
        $mock = $this->createMock(WalletsRepository::class);
        $mock->method('isKeyForWallet')->willReturn(true);
        $mock->method('isWalletLocked')->willReturn(true);
        $mock->method('isKeyForWallet')->willReturn(true);
        $this->app[WalletsRepository::class] = $mock;
        $walletFrom = new Wallet(Uuid::uuid4(), Uuid::uuid4(), false, 50000, null);
        $walletTo = new Wallet(Uuid::uuid4(), Uuid::uuid4(), false, 50001, null);

        $validator = new CreateTransactionValidator($walletFrom, $walletTo, 'fGDSg', 50);

        try {
            $validator->validate();
        } catch (CreateTransactionValidatorException $exception) {
            self::assertEquals('Wallet from is locked', $exception->getMessage());
        }
    }

    public function testValidatorWrongKey()
    {
        $mock = $this->createMock(WalletsRepository::class);
        $mock->method('isKeyForWallet')->willReturn(false);
        $mock->method('isWalletLocked')->willReturn(false);
        $mock->method('isKeyForWallet')->willReturn(true);
        $this->app[WalletsRepository::class] = $mock;
        $walletFrom = new Wallet(Uuid::uuid4(), Uuid::uuid4(), false, 50000, null);
        $walletTo = new Wallet(Uuid::uuid4(), Uuid::uuid4(), false, 50001, null);

        $validator = new CreateTransactionValidator($walletFrom, $walletTo, 'fGDSg', 50);

        try {
            $validator->validate();
        } catch (CreateTransactionValidatorException $exception) {
            self::assertEquals('Invalid key for wallet from', $exception->getMessage());
        }
    }
}
