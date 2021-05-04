<?php

namespace App\Console\Commands;

use App\Models\BalanceHistory;
use Illuminate\Console\Command;

class BalanceHistoryReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance-history:report {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report total amount of transactions user id is optional';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('START =======');
        $this->line('date : ' . date('Y-m-d H:i:s') );
        $user_id = $this->argument('user') ?? null;
        $balanceHistory = clone new BalanceHistory();
        if ($user_id) {
            $totalDeposit = $balanceHistory->where('user_id', $user_id)->where('type', 'deposit')->sum('amount');
            $totalWithdraw =  $balanceHistory->where('user_id', $user_id)->where('type', 'withdraw')->sum('amount');
        }  else {
            $totalDeposit = $balanceHistory->where('type', 'deposit')->sum('amount');
            $totalWithdraw =  $balanceHistory->where('type', 'withdraw')->sum('amount');
        }



        $this->line('total deposit : ' . $totalDeposit);
        $this->line('total withdraw : '. $totalWithdraw);
        $this->line('======= END');
        return 0;
    }
}
