<?php

namespace App\Jobs;

use App\DTO\NotificationDTO;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeadLetterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private $subject
    ) {
        $this->onQueue('deadLetter');
    }

    public function handle(): void
    {
        match (true) {
            $this->subject instanceof NotificationDTO => NotificationJob::dispatch($this->subject),
            default => throw new Exception("Job not found in dead letter queue")
        };
    }
}
