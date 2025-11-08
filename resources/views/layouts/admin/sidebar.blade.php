<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            Anvica<span><strong>Radius</strong></span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            {{-- <p>Your role: {{ Auth::user()->getRoleNames()->first() }}</p> --}}
            <li class="nav-item nav-category">HOTSPOT MANAGER</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#radiusManager" role="button" aria-expanded="false"
                    aria-controls="radiusManager">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Hotspot Manager</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                @php
                    $currentRoute = Route::currentRouteName(); // Get current route name
                @endphp

                <div class="collapse" id="radiusManager">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('plans.index') }}" class="nav-link">Plans</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('vouchers.index') }}" class="nav-link">Vourchers</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#userManager" role="button" aria-expanded="false"
                    aria-controls="userManager">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Users</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                @php
                    $currentRoute = Route::currentRouteName(); // Get current route name
                @endphp

                <div class="collapse" id="userManager">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('radius.users.index') }}" class="nav-link">Create Users</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('radius.users.all.logs') }}" class="nav-link">User Logs</a>
                        </li>
                    </ul>
                </div>
            </li>

            @role('admin')
            <li class="nav-item nav-category">Anvica Setting</li>
            <li class="nav-item">
                <a href="{{ route('identities.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Identity</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('advertisements.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Advertisement</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false"
                    aria-controls="uiComponents">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Admin</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                @php
                    $menuItems = [
                        'users' => 'Users',
                    ];
                @endphp
                <div class="collapse" id="uiComponents">
                    <ul class="nav sub-menu">
                        @foreach ($menuItems as $route => $label)
                            {{-- @canany(["{$route}.index"]) --}}
                            <li class="nav-item">
                                <a href="{{ route("{$route}.index") }}" class="nav-link">{{ $label }}</a>
                            </li>
                            {{-- @endcanany --}}
                        @endforeach
                    </ul>
                </div>
            </li>

            
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#rolesPermission" role="button"
                    aria-expanded="false" aria-controls="rolesPermission">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Role & Permission</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="rolesPermission">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('permissions.index') }}" class="nav-link">Permissions</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">Roles</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rolepermissions.index') }}" class="nav-link">Role Permissions </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#setting" role="button" aria-expanded="false"
                    aria-controls="setting">
                    <i class="link-icon" data-feather="sliders"></i>
                    <span class="link-title">Setting</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="setting">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('options.index') }}" class="nav-link">Option Master</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endrole
        </ul>
    </div>
</nav>
