<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'countries',
        'branches',
        'online_hours',
        'offline_hours',
        'online_cost',
        'offline_cost',
        'total_online_hours',
        'total_offline_hours',
        'total_online_cost',
        'total_offline_cost',
        'standard_online_rate',
        'standard_offline_rate',
        'premium_online_rate',
        'premium_offline_rate',
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
        'online_hours' => 'float',
        'offline_hours' => 'float',
        'online_cost' => 'float',
        'offline_cost' => 'float',
        'total_online_hours' => 'float',
        'total_offline_hours' => 'float',
        'total_online_cost' => 'float',
        'total_offline_cost' => 'float',
        'standard_online_rate' => 'float',
        'standard_offline_rate' => 'float',
        'premium_online_rate' => 'float',
        'premium_offline_rate' => 'float',
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
}
