<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solution extends Model implements Sortable
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
        'overview',
        'image',
        'online_hours',
        'offline_hours',
        'online_cost',
        'offline_cost',
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
        'projects' => 'integer',
        'status' => 'boolean',
    ];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    /**
     * Product relationship
     *
     * A solution belongs to a product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Project Relationship
     *
     * A solution has many projects
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
