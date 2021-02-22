<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddSomeData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('users')->table('users')->insert([
            ['id' => '65910a2b-4c0e-4486-9c8e-ffa87cf6accb', 'name' => 'Bob', 'surname' => 'Seaver', 'email' => 'example@test.com', 'address' => '', 'is_active' => true, 'password' => '$2y$10$wz.lqIn.ERg0wHY.mIjFjOePU0wxMq4jjhKsPFAMMqPE/rbohdJl2', 'token' => '$2y$10$rTFfToPjJvy9WF2AgPE7Seh5YvywR6wZ8wQvq.uwiYi5rvW/qONx6'],
            ['id' => 'db4a1ff3-b8e6-4a0d-9d2a-b2d7fd3859df', 'name' => 'Tom', 'surname' => 'Seaver', 'email' => 'example1@test.com', 'address' => '', 'is_active' => true, 'password' => '$2y$10$hmsRJ0TFtc0DGHJIVMtM/eZeDgUFcaak26gSyZnNuynu1uCwopxLi', 'token' => '$2y$10$lxX3UKPiVc5IvlNvsEDIZuoYkoXra43xQbSod30CBjx7LoNmDKrmW'],
            ['id' => 'd0eae497-893c-4c60-b41b-ae2f49f4d2a2', 'name' => 'Jane', 'surname' => 'Seaver', 'email' => 'example2@test.com', 'address' => '', 'is_active' => true, 'password' => '$2y$10$hSf.DmeBff5FbUreF1GsheYjusYbo/hj.dJ4MFxHr7W3BrxqjK20i', 'token' => '$2y$10$lxX3UKPiVc5IvlNvsEDIZuoYkoXra43xQbSod30CBjx7LoNmDKrmW'],
            ['id' => '5c4bf539-e267-4856-a863-494c1bcf49b4', 'name' => 'Mob', 'surname' => 'Seaver', 'email' => 'example3@test.com', 'address' => '', 'is_active' => true, 'password' => '$2y$10$aTaHkHvF.is/Euj1GdafV.6KXErja/dXFVlLJpC1tFXaVIxIofjjC', 'token' => '$2y$10$rTFfToPjJvy9WF2AgPE7Seh5YvywR6wZ8wQvq.uwiYi5rvW/qONx6'],
            ['id' => '02677504-9a99-4a44-9048-12ed18e725ff', 'name' => 'Ob', 'surname' => 'Seaver', 'email' => 'example4@test.com', 'address' => '', 'is_active' => true, 'password' => '$2y$10$Zy.V5o71ulevYdVCLbU4juV4eZcFu9T/NuUUK7n676l2spJ73VHVq', 'token' => '$2y$10$lxX3UKPiVc5IvlNvsEDIZuoYkoXra43xQbSod30CBjx7LoNmDKrmW'],
            ['id' => '31a198a0-1693-43db-bf9e-353f763aba44', 'name' => 'Den', 'surname' => 'Seaver', 'email' => 'example5@test.com', 'address' => '', 'is_active' => false, 'password' => '$2y$10$4JGimJQYX3El9Dt4rxJ1L.0HjtUDysCgWprFWr2T3zpke8wIiaz9e', 'token' => '$2y$10$rTFfToPjJvy9WF2AgPE7Seh5YvywR6wZ8wQvq.uwiYi5rvW/qONx6'],
            ['id' => 'c95108e8-6ca4-4cce-8206-6b472f7afd96', 'name' => 'Rob', 'surname' => 'Seaver', 'email' => 'example6@test.com', 'address' => '', 'is_active' => true, 'password' => '$2y$10$PBzc/nLIB2opP8Uxtmrg8u6vFAQTe.Wu9xsQ6y.4eWKMM.wlPLppe', 'token' => '$2y$10$rTFfToPjJvy9WF2AgPE7Seh5YvywR6wZ8wQvq.uwiYi5rvW/qONx6'],
        ]);

        DB::connection('finance')->table('wallets')->insert([
            ['id' => '96af9fb1-e55b-45c6-abda-3fecc4957d59', 'user_id' => 'db4a1ff3-b8e6-4a0d-9d2a-b2d7fd3859df', 'wallet_key' => 'SetewEtf', 'balance' => 755443, 'is_locked' => false],
            ['id' => '80d1f345-dccf-47b7-b900-8aabdf85ca3a', 'user_id' => '5c4bf539-e267-4856-a863-494c1bcf49b4', 'wallet_key' => 'GHhfddfG', 'balance' => 55443, 'is_locked' => false],
            ['id' => '1fffc90a-b8bd-4d9b-afa8-d6c02872a1f8', 'user_id' => '5c4bf539-e267-4856-a863-494c1bcf49b4', 'wallet_key' => 'Gfhdfdfg', 'balance' => 3342, 'is_locked' => false],
            ['id' => '2e3f885f-aa50-4475-adfb-6b56432a6cc3', 'user_id' => '5c4bf539-e267-4856-a863-494c1bcf49b4', 'wallet_key' => 'GFHdhbdrd', 'balance' => 52565, 'is_locked' => false],
            ['id' => '2904e3ef-c438-4ec2-8345-1de5071a7f16', 'user_id' => '65910a2b-4c0e-4486-9c8e-ffa87cf6accb', 'wallet_key' => 'Hthvcbgtt', 'balance' => 235235622, 'is_locked' => false],
            ['id' => '2b8ed342-509e-482b-9ac4-2d40eb37fee3', 'user_id' => 'c95108e8-6ca4-4cce-8206-6b472f7afd96', 'wallet_key' => 'HtgbnHrht', 'balance' => 5325235, 'is_locked' => false],
            // Admin wallet
            ['id' => 'd7f3d8ad-f967-4212-b90d-a108013cf481', 'user_id' => 'd7f3d8ad-f967-4212-b90d-a108013cf481', 'wallet_key' => 'HtgbnHrht', 'balance' => 0, 'is_locked' => false],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
