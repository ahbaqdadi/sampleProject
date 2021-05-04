<?php

namespace Tests\Feature;

use App\Models\BalanceHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BalanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_user_must_set()
    {
        $this->seed();
        $user = User::first();
        $response = $this->get('/api/get-balance/'.$user->id);
        $this->assertEquals($response->json(), ["balance" => 0]);
    }

    public function test_create_deposit_money_to_user()
    {
        $this->seed();
        $user = User::first();
        $balanceHistory = BalanceHistory::first();

        // create or get User
        $response = $this->get('/api/get-balance/'.$user->id);

        // add deposit money
        $response = $this->post('/api/add-money', ["user_id" => $user->id, "amount" => 100]);
        $this->assertEquals($response->json(), ["reference_id" => 1000000]);
    }

    public function test_create_withdraw_money_to_user()
    {
        $this->seed();
        $user = User::first();
        $balanceHistory = BalanceHistory::first();

        // create or get User
        $response = $this->get('/api/get-balance/'.$user->id);

        // add deposit money
        $response = $this->post('/api/add-money', ["user_id" => $user->id, "amount" => 100]);

        // add withdraw money
        $response = $this->post('/api/add-money', ["user_id" => $user->id, "amount" => -50]);
        $this->assertEquals($response->json(), ["reference_id" => 1000002]);
    }

    public function test_check_deposit_money_user()
    {
        $this->seed();
        $user = User::first();
        $balanceHistory = BalanceHistory::first();

        // create or get User
        $response = $this->get('/api/get-balance/'.$user->id);

        // add deposit money
        $response = $this->post('/api/add-money', ["user_id" => $user->id, "amount" => 100]);

        // check user money
        $response = $this->get('/api/get-balance/'.$user->id);

        $this->assertEquals($response->json(), ["balance" => 100]);
    }

    public function test_check_withdraw_money_to_user()
    {
        $this->seed();
        $user = User::first();
        $balanceHistory = BalanceHistory::first();

        // create or get User
        $response = $this->get('/api/get-balance/'.$user->id);

        // add deposit money
        $response = $this->post('/api/add-money', ["user_id" => $user->id, "amount" => 100]);

        // add withdraw money
        $response = $this->post('/api/add-money', ["user_id" => $user->id, "amount" => -40]);

        // check user money
        $response = $this->get('/api/get-balance/'.$user->id);

        $this->assertEquals($response->json(), ["balance" => 60]);
    }

    public function test_error_message_withdraw_money_to_user()
    {
        $this->seed();
        $user = User::first();
        $balanceHistory = BalanceHistory::first();

        // create or get User
        $response = $this->get('/api/get-balance/'.$user->id);

        // add withdraw money
        $response = $this->post('/api/add-money', ["user_id" => $user->id, "amount" => -40]);

        // check user money
        $response = $this->get('/api/get-balance/'.$user->id);

        $this->assertEquals($response->json(), ["balance" => 0]);
    }
}
