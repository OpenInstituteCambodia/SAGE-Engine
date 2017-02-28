<li><a href="{{ url('dashboard') }}">Dashboard</a></li>
<li><a href="{{ url('project') }}">Projects</a></li>
<li><a href="{{ url('dashboard/users') }}">Users</a></li>
<div class="divider"></div>

<!-- For Developer Rold Only -->
@if(Auth::user()->role == 1)
  <li><a href="{{ url('developer') }}">Developer</a></li>
  <div class="divider"></div>
@endif
