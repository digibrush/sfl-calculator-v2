<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order',
        'type',
        'name',
        'overview',
        'image',
        'video',
        'online_hours',
        'offline_hours',
        'online_cost',
        'offline_cost',
        'solutions',
        'projects',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'online_hours' => 'float',
        'offline_hours' => 'float',
        'online_cost' => 'float',
        'offline_cost' => 'float',
        'solutions' => 'integer',
        'projects' => 'integer',
        'status' => 'boolean',
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    /**
     * Solution Relationship
     *
     * A product has many solutions
     */
    public function solutions()
    {
        return $this->hasMany(Solution::class);
    }

    /**
     * Quote relationship
     *
     * A product belongs to a quote
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
