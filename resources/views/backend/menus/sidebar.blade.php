<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight" style="color: white">PANEL DE CONTROL</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">

                <!-- ROLES Y PERMISOS -->
                @can('sidebar.roles.y.permisos')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="far fa-edit nav-icon"></i>
                        <p>
                            Roles y Permisos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rol y Permisos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.permisos.index') }}" target="frameprincipal" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuario</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                <!-- APIs -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('apis') }}">
                        <i class="fas fa-code-branch nav-icon"></i>
                        <p>APIs</p>
                    </a>
                </li>

                <!-- Trabajadores -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('workers') }}">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Trabajadores</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>




