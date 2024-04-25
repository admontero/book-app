<?php

namespace App\Jobs;

use App\Enums\FineStatusEnum;
use App\Models\Fine;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateLoanFineJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Loan $loan
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $days = Carbon::parse(today()->toDateString())->diffInDays($this->loan->limit_date);

        $total = $this->loan->fine_amount * $days;

        Fine::updateOrCreate([
            'loan_id' => $this->loan->id,
        ], [
            'user_id' => $this->loan->user_id,
            'days' => $days,
            'total' => $total,
            'status' => FineStatusEnum::PENDIENTE->value,
        ]);
    }
}
