<?php

namespace App\Jobs;

use App\DTO\NotificationDTO;
use App\Services\NotificationService;
use Exception;
use Illuminate\Bus\Queueable;
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
        try {
            if (NotificationService::send() === false) {
                throw new Exception("Notification failed");
            }
        } catch (\Throwable $th) {
            DeadLetterJob::dispatch($this->notification);
        }
        
    }
}
