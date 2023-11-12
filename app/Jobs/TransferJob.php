<?php

namespace App\Jobs;

use App\DTO\TransferDTO;
use App\Models\BankAccount;
use App\Models\Transfer;
use App\Services\TransferService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransferJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private BankAccount $payerAccount,
        private BankAccount $payeeAccount,
        private TransferDTO $transfer,
        private Transfer $createdTransfer,
    ) {
        $this->onQueue('transfer');
    }

    public function handle(): void
    {
        (new TransferService)->makeTransfer($this->payerAccount, $this->payeeAccount, $this->transfer, $this->createdTransfer);
    }
}
