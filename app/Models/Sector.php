<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
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
     * Company Relationship
     *
     * A sector has many companies
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Industry Relationship
     *
     * A sector has many industries
     */
    public function industries()
    {
        return $this->hasMany(Industry::class);
    }
}
