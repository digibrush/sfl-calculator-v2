<?php

namespace App\Jobs;

use App\Models\Document;
use App\Models\Quote;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateQuoteTechnicalPDF implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $document;

    /**
     * Create a new job instance.
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $document = Document::findOrFail($this->document->id);
        $quote = Quote::findOrFail($document->quote->id);

        $data = [
            'quote' => $quote
        ];
        $pdf =  SnappyPDF::loadView('pdf.quote-technical', $data)
            ->setOption('lowquality', false)
            ->setOption('no-stop-slow-scripts', true)
            ->setOption('enable-javascript', false)
            ->setOption('javascript-delay', 13500)
            ->setOption('margin-bottom', '0mm')
            ->setOption('margin-top', '0mm')
            ->setOption('margin-right', '0mm')
            ->setOption('margin-left', '0mm')
            ->setOption('page-height', '295mm')
            ->setOption('page-width', '181mm')
            ->setPaper('a4', 'landscape');
        $filename = date('YmdHis');
        $pdf->save(storage_path('app/public/quotes/'.$quote->id.'/'.$filename.'.pdf'));

        $document->update([
            'status' => 'generated',
            'technical' => env('APP_URL').'/storage/quotes/'.$quote->id.'/'.$filename.'.pdf',
        ]);
    }
}
