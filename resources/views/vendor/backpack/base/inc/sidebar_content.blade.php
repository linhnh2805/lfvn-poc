<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('personal') }}'><i class='nav-icon la la-user'></i> Personals</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('contact') }}'><i class='nav-icon la la la-envelope'></i> Contacts</a></li>
<!-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('logcic') }}'><i class='nav-icon la la-question'></i> LogCics</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('logsms') }}'><i class='nav-icon la la-question'></i> LogSms</a></li> -->
<li class='nav-item'><a class='nav-link' href='/admin/report'><i class='nav-icon la la-bar-chart'></i> Report</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon la la-terminal'></i> Logs</a></li>

<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
	<ul class="nav-dropdown-items">
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
	</ul>
</li>