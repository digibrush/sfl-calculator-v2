<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
        'status',
        'financial',
        'technical',
    ];

    /**
     * Quote relationship
     *
     * A document belongs to a quote
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    /**
     * Email Relationship
     *
     * A document has many emails
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }
}
