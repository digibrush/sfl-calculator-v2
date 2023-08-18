<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reciepient',
        'status',
    ];

    /**
     * Quote relationship
     *
     * A email belongs to a quote
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    /**
     * Document relationship
     *
     * A email belongs to a document
     */
    public function document()
    {
        return $this->belongsTo(Document::class)->where('status','generated');
    }
}
