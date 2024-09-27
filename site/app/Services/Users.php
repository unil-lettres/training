<?php

namespace App\Services;

use App\User;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class Users
{
    /**
     * Return all the users with a specific role.
     */
    public function usersWithRole(string $role): Collection
    {
        return User::whereJsonContains('roles', $role)->get();
    }

    /**
     * Return all the users with the admin role.
     */
    public function admins(): Collection
    {
        return $this->usersWithRole('admin');
    }

    /**
     * Return all the users with the notification role.
     */
    public function notifications(): Collection
    {
        return $this->usersWithRole('notification');
    }

    /**
     * Send mail to users with a specific role.
     */
    public function mailUsersWithRole(string $role, Mailable $mail): void
    {
        $users = $this->usersWithRole($role);

        if ($users->isNotEmpty()) {
            Mail::to($users)->send($mail);
        }
    }

    /**
     * Notify users with a specific role.
     */
    public function notifyUsersWithRole(string $role, string $title, string $content): void
    {
        $users = $this->usersWithRole($role);

        if ($users->isNotEmpty()) {
            $users->each(function ($user) use ($title, $content) {
                Notification::make()
                    ->title($title)
                    ->body($content)
                    ->sendToDatabase($user);
            });
        }
    }
}
