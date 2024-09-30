<?php

namespace App;

use App\Models\Request;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements FilamentUser
{
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
        'notification' => 'Notification',
        'super-editor' => 'Super Éditeur',
        'admin' => 'Admin',
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

    /**
     * Check if the user can access the Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['admin', 'super-editor']);
    }

    /**
     * Set the user's password.
     */
    public function setPasswordAttribute(?string $value): void
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::isHashed($value) ? $value : Hash::make($value);
        }
    }

    /**
     * Check if the user has a certain role.
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return !empty(array_intersect($roles, $this->roles ?? []));
        }

        return in_array($roles, $this->roles ?? []);
    }
}
