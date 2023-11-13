<?php

namespace App\Jobs;

use App\DTO\NotificationDTO;
use App\Services\DispatchJobService;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private NotificationDTO $notification
    ) {
        $this->onQueue('notification');
    }

    public function handle(): void
    {
        if (NotificationService::send() === false) {
            DeadLetterJob::dispatch($this->notification);
        }
    }
}
