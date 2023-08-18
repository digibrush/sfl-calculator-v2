<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Sector relationship
     *
     * A industry belongs to a sector
     */
    public function companySector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    /**
     * Company Relationship
     *
     * A industry has many companies
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
