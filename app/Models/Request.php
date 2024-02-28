<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'data',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Quote relationship
     *
     * A request belongs to a quote
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    /**
     * User relationship
     *
     * A request belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
