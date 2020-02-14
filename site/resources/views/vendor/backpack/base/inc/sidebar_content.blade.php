<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class='nav-item'><a class='nav-link' href="{{ backpack_url('dashboard') }}"><i class="nav-icon fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('status') }}'><i class='nav-icon fa fa-tasks'></i> <span>Décisions</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('type') }}'><i class='nav-icon fa fa-th'></i> <span>Types</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('training') }}'><i class='nav-icon fa fa-certificate'></i> <span>Formations</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('request') }}'><i class='nav-icon fa fa-bell'></i> <span>Demandes</span></a></li>
<!-- Users, Roles Permissions -->
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href="#"><i class="nav-icon fa fa-group"></i>Utilisateurs</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-user"></i> <span>Utilisateurs</span></a></li>
        <li class='nav-item'><a class='nav-link' href="{{ backpack_url('role') }}"><i class="nav-icon fa fa-group"></i> <span>Rôles</span></a></li>
        <li class='nav-item'><a class='nav-link' href="{{ backpack_url('permission') }}"><i class="nav-icon fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
