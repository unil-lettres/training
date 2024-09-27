<?php

namespace App;

use App\Models\Request;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use CrudTrait;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'roles',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $role = [
        'admin' => 'Admin',
        'notification' => 'Notification',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'roles' => 'array',
        ];
    }

    /**
     * Get the requests for the user.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    // Set the user's password
    public function setPasswordAttribute(?string $value): void
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Check if the user has a certain role
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return !empty(array_intersect($roles, $this->roles ?? []));
        }

        return in_array($roles, $this->roles ?? []);
    }

    /**
     * Assign roles to the user
     */
    public function assignRoles(array|string $roles): void
    {
        // Merge new roles with existing ones
        $existingRoles = $this->roles ?? [];

        // Convert roles to array if it's a string
        if (is_string($roles)) {
            $roles = explode(',', $roles);
        }

        $this->roles = array_unique(array_merge($existingRoles, $roles));
        $this->save();
    }

    /**
     * Remove roles from the user
     */
    public function removeRoles(array|string $roles): void
    {
        $existingRoles = $this->roles ?? [];

        if (is_string($roles)) {
            $roles = explode(',', $roles);
        }

        $this->roles = array_diff($existingRoles, $roles);
        $this->save();
    }
}
