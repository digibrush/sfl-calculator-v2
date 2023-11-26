<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use Filament\Models\Contracts\FilamentUser;

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
}
