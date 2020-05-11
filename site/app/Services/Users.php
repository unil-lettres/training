<?php
namespace App\Services;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class Users
{
    /**
     * Return all the users with a specific role.
     *
     * @param string $role
     *
     * @return Collection $users
     */
    public function usersWithRole($role) {
        $users = User::with('roles')->get();
        return $users->filter(function ($user) use ($role) {
            return $user->hasRole($role);
        });
    }

    /**
     * Return all the users with the admin role.
     *
     * @return Collection $users
     */
    public function admins() {
        return $this->usersWithRole('Admin');
    }

    /**
     * Return all the users with the notification role.
     *
     * @return Collection $users
     */
    public function notifications() {
        return $this->usersWithRole('Notification');
    }

    /**
     * Send mail to users with a specific role.
     *
     * @param string $role
     * @param Mailable $mail
     *
     * @return void
     */
    public function mailUsersWithRole($role, $mail) {
        $users = $this->usersWithRole($role);

        if ($users->isNotEmpty()) {
            Mail::to($users)->send($mail);
        }
    }
}
