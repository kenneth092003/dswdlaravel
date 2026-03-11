<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string $firstname
 * @property string $lastname
 * @property string $employee_id
 * @property string $email
 * @property string $role
 * @property bool $is_approved
 * @property \Illuminate\Support\Carbon|null $approved_at
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'firstname',
        'lastname',
        'employee_id',
        'email',
        'role',
        'password',
        'is_approved',
        'approved_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class);
    }

    public function purchaseRequestHistories()
    {
        return $this->hasMany(PurchaseRequestHistory::class, 'acted_by');
    }

    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }
}