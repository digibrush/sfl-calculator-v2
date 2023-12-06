<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Quote extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'title',
        'reference',
        'countries',
        'branches',
        'hours',
        'solutions',
        'projects',
        'cost',
        'discount',
        'discount_note',
        'discount_amount',
        'total_cost',
        'standard_online_rate',
        'standard_offline_rate',
        'premium_online_rate',
        'premium_offline_rate',
        'converted',
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'type',
        'title',
        'reference',
        'countries',
        'branches',
        'hours',
        'solutions',
        'projects',
        'cost',
        'discount',
        'discount_note',
        'discount_amount',
        'total_cost',
        'standard_online_rate',
        'standard_offline_rate',
        'premium_online_rate',
        'premium_offline_rate',
        'converted',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'countries' => 'integer',
        'branches' => 'integer',
        'cost' => 'float',
        'discount_amount' => 'float',
        'total_cost' => 'float',
        'converted' => 'boolean',
    ];

    /**
     * Client relationship
     *
     * A quote belongs to a client
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Client relationship
     *
     * A quote belongs to a assignee
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Product Relationship
     *
     * A quote has many products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Document Relationship
     *
     * A quote has many documents
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Email Relationship
     *
     * A quote has many emails
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }
}
