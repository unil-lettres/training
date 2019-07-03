<?php
namespace App\Services;

use App\Models\BackpackUser;
use Illuminate\Support\Facades\Mail;

class Users
{
    /**
     * Return all the users with a specific role.
     *
     * @param string $role
     *
     * @return BackpackUser $users
     */
    public function usersWithRole($role) {
        $users = BackpackUser::with('roles')->get();
        return $users->filter(function ($user) use ($role) {
            return $user->hasRole($role);
        });
    }

    /**
     * Return all the users with the admin role.
     *
     * @return BackpackUser $users
     */
    public function admins() {
        return $this->usersWithRole('Admin');
    }

    /**
     * Return all the users with the notification role.
     *
     * @return BackpackUser $users
     */
    public function notifications() {
        return $this->usersWithRole('Notification');
    }

    /**
     * Return all the users with the notification role.
     *
     * @param string $role
     * @param mixed $mail
     *
     * @return void
     */
    public function mailUsersWithRole($role, $mail) {
        $users = $this->usersWithRole($role);

        if ($users->count()) {
            Mail::to($users)->send($mail);
        }
    }
}
