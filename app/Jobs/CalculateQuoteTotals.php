<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateQuoteTotals implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $quote;

    /**
     * Create a new job instance.
     */
    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $quote = $this->quote;
        $grossTotal = $quote->cost;
        $discountAmount = ($grossTotal * $quote->discount)/100;
        $netTotal = (float) ($grossTotal - $discountAmount);
        $quote->total_cost = $netTotal;
        $quote->discount_amount = $discountAmount;
        $quote->saveQuietly();
    }
}
