<?php

namespace App\Console\Commands;

use App\Enums\LoanStatusEnum;
use App\Jobs\CalculateLoanFineJob;
use App\Models\Loan;
use Illuminate\Console\Command;

class LoanInProgressCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:loan-in-progress-check-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fineable_overdue_loans = Loan::where('status', LoanStatusEnum::EN_CURSO)
            ->where('is_fineable', 1)
            ->where('limit_date', '<', today()->toDateString())
            ->get();

        $fineable_overdue_loans->each(fn ($loan) => CalculateLoanFineJob::dispatch($loan));
    }
}
