<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable,FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'password',
        'discount_rate',
        'discount',
    ];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = [
        'type',
        'name',
        'email',
        'password',
        'discount_rate',
        'discount',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'discount_rate' => 'float',
        'discount' => 'array',
    ];

    public function canAccessFilament(): bool
    {
        return true;
    }

    /**
     * Company relationship
     *
     * A user belongs to a company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Client Quotes Relationship
     *
     * A user has many client quotes
     */
    public function clientQuotes()
    {
        return $this->hasMany(Quote::class, 'client_id');
    }

    /**
     * Assignee Quotes Relationship
     *
     * A user has many assignee quotes
     */
    public function assigneeQuotes()
    {
        return $this->hasMany(Quote::class, 'assignee_id');
    }

    /**
     * Reporting Manager relationship
     *
     * A user belongs to a reporting manager
     */
    public function reportingManager()
    {
        return $this->belongsTo(User::class,'reporting_manager');
    }

    /**
     * Subordinate relationship
     *
     * A user (reporting manager) has many subordinates
     */
    public function subordinates()
    {
        return $this->hasMany(User::class,'reporting_manager');
    }

    /**
     * Requests relationship
     *
     * A user has many requests
     */
    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}
