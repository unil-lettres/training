{{-- This file is used for menu items by any Backpack v6 theme --}}
<x-backpack::menu-item title="{{ trans('backpack::base.dashboard') }}" icon="la la-dashboard" :link="backpack_url('dashboard')" />
<x-backpack::menu-item title="Décisions" icon="la la-tasks" :link="backpack_url('status')" />
<x-backpack::menu-item title="Catégories" icon="la la-th" :link="backpack_url('category')" />
<x-backpack::menu-item title="Formations" icon="la la-certificate" :link="backpack_url('training')" />
<x-backpack::menu-item title="Demandes" icon="la la-bell" :link="backpack_url('request')" />
<!-- Users, Roles Permissions -->
<x-backpack::menu-dropdown title="Utilisateurs" icon="la la-group">
    <x-backpack::menu-dropdown-item title="Utilisateurs" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Rôles" icon="la la-user-cog" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissions" icon="la la-key" :link="backpack_url('permission')" />
</x-backpack::menu-dropdown>
