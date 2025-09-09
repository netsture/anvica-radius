<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            DB<span><strong>Manage</strong></span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">         
            <li class="nav-item nav-category">Database</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#radius" role="button" aria-expanded="false"
                    aria-controls="radius">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">radius</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="radius">
                    <ul class="nav sub-menu">
                        @php
                            DB::statement("USE radius");
                            $tables = DB::select("SHOW TABLES");
                            $key = "Tables_in_radius";
                            $tableList = collect($tables)->pluck($key);
                        @endphp
                        @foreach($tableList as $table)
                            <li class="nav-item">
                                <a href="{{ route('rows', ['radius', $table]) }}" class="nav-link">{{ $table }}</a>
                            </li>
                        @endforeach
                        
                    </ul>
                </div>

            </li>
        </ul>   
    </div>
</nav>
