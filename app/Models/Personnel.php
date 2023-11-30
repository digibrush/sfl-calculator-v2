<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'rate',
    ];

    /**
     * Project Relationship
     *
     * A personnel has many projects
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
