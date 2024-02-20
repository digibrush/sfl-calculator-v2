<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Project extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'price_category',
        'price_tier',
        'personnel_id',
        'countries',
        'branches',
        'hours',
        'cost',
        'total_hours',
        'total_cost',
        'rate',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'countries' => 'integer',
        'branches' => 'integer',
        'hours' => 'float',
        'cost' => 'float',
        'total_hours' => 'float',
        'total_cost' => 'float',
        'rate' => 'float',
        'status' => 'boolean',
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    /**
     * Solution relationship
     *
     * A project belongs to a solution
     */
    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    /**
     * Personnel relationship
     *
     * A project belongs to a personnel
     */
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }
}
