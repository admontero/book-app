<?php

namespace App\Listeners;

use App\Enums\CopyStatusEnum;
use App\Events\LoanCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCopyStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LoanCreated $event): void
    {
        $event->loan->copy->update([
            'status' => CopyStatusEnum::OCUPADA,
        ]);
    }
}
