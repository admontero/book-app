<?php

namespace App\Jobs;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateLoanSerialJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Loan $loan;

    /**
     * Create a new job instance.
     */
    public function __construct(int $loanId)
    {
        $this->onQueue('loanSerialQueue');

        $this->loan = Loan::findOrFail($loanId);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $nextSerial = (Loan::max('serial_number') ?? 0) + 1;

        $this->loan->serial_number = $nextSerial;

        $serialFormatted = str_pad($this->loan->serial_number, get_total_digits_in_a_number($this->loan->serial_number) + 2, '0', STR_PAD_LEFT);

        $this->loan->serial = "PRE-{$serialFormatted}";

        $this->loan->save();
    }
}
