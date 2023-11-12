<?php

namespace App\Jobs;

use App\DTO\DepositDTO;
use App\Models\BankAccount;
use App\Models\Transfer;
use App\Services\DepositService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DepositJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private BankAccount $bankAccount,
        private DepositDTO $deposit,
        private Transfer $createdTransfer,
    ) {
        $this->onQueue('deposit');
    }

    public function handle(): void
    {
        (new DepositService)->makeDeposit($this->bankAccount, $this->deposit, $this->createdTransfer);
    }
}
