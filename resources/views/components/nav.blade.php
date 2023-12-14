<?php
use Illuminate\Support\Facades\Route;
?>
<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
            <a href="{{ route('dashboard.dashboard') }}" class="nav-link {{ Route::is(URL::current()) ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>

        @foreach ($items as $item)
            @can($item['ability'] ?? false)
                <li class="nav-item">
                    <a href="{{ route($item['route']) }}" class="nav-link {{ Route::is($item['active']) ? 'active' : '' }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <p>
                            {{ $item['title'] }}
                            @if (isset($item['new']))
                                <span class="right badge badge-danger">New</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endcan
        @endforeach

        <li class="nav-item">
            <a href="{{ route('dashboard.roles.index') }}"
                class="nav-link {{ Route::is(URL::current()) ? 'active' : '' }}">
                <i class="fas fa-cog nav-icon"></i>
                <p>
                    Roles
                </p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
