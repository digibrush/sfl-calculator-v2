<?php

namespace App\Observers;

use App\Jobs\GenerateQuoteFinancialPDF;
use App\Jobs\GenerateQuoteTechnicalPDF;
use App\Models\Document;

class DocumentObserver
{
    /**
     * Handle the Document "created" event.
     */
    public function created(Document $document): void
    {
        GenerateQuoteFinancialPDF::dispatch($document)
            ->delay(now()->addSeconds(2));
        GenerateQuoteTechnicalPDF::dispatch($document)
            ->delay(now()->addSeconds(2));
    }

    /**
     * Handle the Document "updated" event.
     */
    public function updated(Document $document): void
    {
        //
    }

    /**
     * Handle the Document "deleted" event.
     */
    public function deleted(Document $document): void
    {
        //
    }

    /**
     * Handle the Document "restored" event.
     */
    public function restored(Document $document): void
    {
        //
    }

    /**
     * Handle the Document "force deleted" event.
     */
    public function forceDeleted(Document $document): void
    {
        //
    }
}
