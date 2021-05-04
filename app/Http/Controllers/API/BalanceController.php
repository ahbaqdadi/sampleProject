<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AddMoneyRequest;
use App\Http\Resources\API\BalanceAddMoneyResource;
use App\Http\Resources\API\BalanceGetResource;
use App\Models\Balance;
use App\Models\User;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * @param $user_id
     * @return BalanceGetResource
     */
    public function get($user_id): BalanceGetResource
    {
        $user = User::findOrFail($user_id);
        $balance = Balance::firstOrCreate([
            'user_id' => $user_id
        ], [
            'amount' => 0
        ]);
        return new BalanceGetResource($balance);
    }

    /**
     * @param AddMoneyRequest $request
     * @return BalanceAddMoneyResource
     */
    public function addMoney(AddMoneyRequest $request): BalanceAddMoneyResource
    {
        $user_id = $request->post('user_id');
        $amount = $request->post('amount');
        $balance = Balance::where('user_id', $user_id)->first();
        $type = 'deposit';
        if ($amount < 0) {
            $amount *= -1;
            $type = 'withdraw';
            $balance->amount = bcsub($balance->amount, $amount, 2);
        } else {
            $balance->amount = bcadd($balance->amount, $amount, 2);
        }
        $balance->save();
        $balanceHistory = $balance->histories()->create([
            'user_id' => $user_id,
            'type' => $type,
            'amount' => $amount
        ]);
        return new BalanceAddMoneyResource($balanceHistory);
    }
}
