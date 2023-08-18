<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Company extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address_1',
        'address_2',
        'city',
        'state',
        'country',
        'sector',
        'industry',
        'scale',
        'image',
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'name',
        'address_1',
        'address_2',
        'city',
        'state',
        'country',
        'sector',
        'industry',
        'scale',
        'image',
    ];

    /**
     * User Relationship
     *
     * A company has many users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Sector relationship
     *
     * A company belongs to a sector
     */
    public function companySector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

    /**
     * Industry relationship
     *
     * A company belongs to a industry
     */
    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
