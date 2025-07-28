<!-- Sidebar -->
<nav id="sidebar" class="bg-white text-dark d-none d-md-block" style="width: 250px; min-height: 100vh; position: fixed; top: 0; left: 0; box-shadow: 0 0 10px rgba(0,0,0,0.1); transition: width 0.3s;">
    <div class="sidebar-header p-3 d-flex justify-content-center">
        <a href="{{ route('dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            {{-- @if(config('application.logo'))
                <img src="{{ asset(config('application.logo')) }}" alt="Logo" class="h-8 w-auto" style="max-height: 32px;">
            @endif --}}
            <span class="fw-bold fs-5 text-black">{{ config('application.name', 'SG.Events') }}</span>
        </a>
    </div>

    <ul class="list-unstyled components p-3" style="padding-bottom: 100px;">
        <li class="mb-2">
            <a href="{{ route('dashboard') }}" class="text-dark text-decoration-none d-flex align-items-center p-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2 text-black sidebar-icon"></i>
                <span class="sidebar-text text-dark">{{ __('Tableau de bord') }}</span>
            </a>
        </li>
        
        @if(Auth::user()->role === 'admin')
            {{-- Organisateurs --}}
            <li class="mb-2">
                <div class="dropdown">
                    <a href="#" class="text-dark text-decoration-none d-flex align-items-center justify-content-between p-2 dropdown-toggle organizer-link" data-bs-toggle="collapse" data-bs-target="#organisateursSubmenu" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-gear me-2 text-info sidebar-icon"></i>
                            <span class="sidebar-text">{{ __('Organisateurs') }}</span>
                        </div>
                    </a>
                    <div class="collapse" id="organisateursSubmenu">
                        <ul class="list-unstyled ps-4 py-2">
                            <li class="mb-1">
                                <a href="{{ route('organizers') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 organizer-link {{ request()->routeIs('organisateurs') ? 'active' : '' }}">
                                    <i class="bi bi-list-ul me-2 text-info sidebar-icon"></i>
                                    <span class="sidebar-text">{{ __('Liste') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('organizers.create') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 organizer-link {{ request()->routeIs('organisateurs.create') ? 'active' : '' }}">
                                    <i class="bi bi-plus-circle me-2 text-info sidebar-icon"></i>
                                    <span class="sidebar-text">{{ __('Ajouter') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        @endif
        
        {{-- Événements --}}
        <li class="mb-2">
            <div class="dropdown">
                <a href="#" class="text-dark text-decoration-none d-flex align-items-center justify-content-between p-2 dropdown-toggle event-link" data-bs-toggle="collapse" data-bs-target="#evenementsSubmenu" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-event me-2 text-success sidebar-icon"></i>
                        <span class="sidebar-text">{{ __('Événements') }}</span>
                    </div>
                </a>
                <div class="collapse" id="evenementsSubmenu">
                    <ul class="list-unstyled ps-4 py-2">
                        <li class="mb-1">
                            <a href="{{ route('events') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 event-link {{ request()->routeIs('evenements') ? 'active' : '' }}">
                                <i class="bi bi-list-ul me-2 text-success sidebar-icon"></i>
                                <span class="sidebar-text">{{ __('Liste') }}</span>
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('events.canceled') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 event-link {{ request()->routeIs('events.canceled') ? 'active' : '' }}">
                                <i class="bi bi-list-ul me-2 text-danger sidebar-icon"></i>
                                <span class="sidebar-text">{{ __('Événements annulés') }}</span>
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('events.passed') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 event-link {{ request()->routeIs('events.passed') ? 'active' : '' }}">
                                <i class="bi bi-list-ul me-2 text-gray-500 sidebar-icon"></i>
                                <span class="sidebar-text">{{ __('Événements passés') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('events.create') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 event-link {{ request()->routeIs('evenements.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-circle me-2 text-success sidebar-icon"></i>
                                <span class="sidebar-text">{{ __('Ajouter') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>

        @if(Auth::user()->role === 'admin')
            {{-- Paramètres --}}
            <li class="mb-2">
                <div class="dropdown">
                    <a href="#" class="text-dark text-decoration-none d-flex align-items-center justify-content-between p-2 dropdown-toggle settings-link" data-bs-toggle="collapse" data-bs-target="#parametresSubmenu" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-gear me-2 text-secondary sidebar-icon"></i>
                            <span class="sidebar-text">{{ __('Paramètres') }}</span>
                        </div>
                    </a>
                    <div class="collapse" id="parametresSubmenu">
                        <ul class="list-unstyled ps-4 py-2">
                            <li class="mb-1">
                                <a href="{{ route('categories') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 settings-link {{ request()->routeIs('categories') ? 'active' : '' }}">
                                    <i class="bi bi-tags me-2 text-secondary sidebar-icon"></i>
                                    <span class="sidebar-text">{{ __('Catégories') }}</span>
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('regions') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 settings-link {{ request()->routeIs('regions') ? 'active' : '' }}">
                                    <i class="bi bi-globe me-2 text-secondary sidebar-icon"></i>
                                    <span class="sidebar-text">{{ __('Régions') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cities') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 settings-link {{ request()->routeIs('villes') ? 'active' : '' }}">
                                    <i class="bi bi-building me-2 text-secondary sidebar-icon"></i>
                                    <span class="sidebar-text">{{ __('Villes') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('applications') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 settings-link {{ request()->routeIs('applications') ? 'active' : '' }}">
                                    <i class="bi bi-grid-3x3-gap me-2 text-secondary sidebar-icon"></i>
                                    <span class="sidebar-text">{{ __('Applications') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        @endif
    </ul>

    <div class="sidebar-footer p-3 border-top">
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle w-100 text-start" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-2 text-black sidebar-icon"></i>
                <span class="sidebar-text">{{ Auth::user()->name }}</span>
            </button>
            <ul class="dropdown-menu w-100" aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person me-2 text-black"></i>
                        {{ __('Profil') }}
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="bi bi-box-arrow-right me-2 text-black"></i>
                            {{ __('Déconnexion') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Mobile Header -->
<div class="d-md-none bg-white shadow-sm position-fixed w-100" style="top: 0; left: 0; z-index: 1000;">
    <div class="d-flex justify-content-between align-items-center p-3">
        <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
            <i class="bi bi-list text-black"></i>
        </button>
        <a href="{{ route('dashboard') }}" class="text-decoration-none">
            <span class="fw-bold fs-5 text-black">Events</span>
        </a>
        <div style="width: 40px;"></div> <!-- Spacer for alignment -->
    </div>
</div>

<!-- Mobile Sidebar -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
        <h1 class="offcanvas-title text-black fw-bold" id="mobileSidebarLabel" style="font-size: 2rem;">Events</h1>
        <button type="button" class="btn-close" style="position: fixed; right: 20px;" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="list-unstyled components p-3" style="padding-bottom: 100px;">
            <li class="mb-2">
                <a href="{{ route('dashboard') }}" class="text-dark text-decoration-none d-flex align-items-center p-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text text-dark">{{ __('Tableau de bord') }}</span>
                </a>
            </li>
            
            @if(Auth::user()->role === 'admin')
                {{-- Organisateurs --}}
                <li class="mb-2">
                    <div class="dropdown">
                        <a href="#" class="text-dark text-decoration-none d-flex align-items-center justify-content-between p-2 dropdown-toggle organizer-link" data-bs-toggle="collapse" data-bs-target="#organisateursSubmenu" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-gear me-2 text-info sidebar-icon"></i>
                                <span class="sidebar-text">{{ __('Organisateurs') }}</span>
                            </div>
                        </a>
                        <div class="collapse" id="organisateursSubmenu">
                            <ul class="list-unstyled ps-4 py-2">
                                <li class="mb-1">
                                    <a href="{{ route('organizers') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 organizer-link {{ request()->routeIs('organisateurs') ? 'active' : '' }}">
                                        <i class="bi bi-list-ul me-2 text-info sidebar-icon"></i>
                                        <span class="sidebar-text">{{ __('Liste') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('organizers.create') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 organizer-link {{ request()->routeIs('organisateurs.create') ? 'active' : '' }}">
                                        <i class="bi bi-plus-circle me-2 text-info sidebar-icon"></i>
                                        <span class="sidebar-text">{{ __('Ajouter') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            @endif
            
            {{-- Événements --}}
            <li class="mb-2">
                <div class="dropdown">
                    <a href="#" class="text-dark text-decoration-none d-flex align-items-center justify-content-between p-2 dropdown-toggle event-link" data-bs-toggle="collapse" data-bs-target="#evenementsSubmenu" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-event me-2 text-success sidebar-icon"></i>
                            <span class="sidebar-text">{{ __('Événements') }}</span>
                        </div>
                    </a>
                    <div class="collapse" id="evenementsSubmenu">
                        <ul class="list-unstyled ps-4 py-2">
                            <li class="mb-1">
                                <a href="{{ route('events') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 event-link {{ request()->routeIs('evenements') ? 'active' : '' }}">
                                    <i class="bi bi-list-ul me-2 text-success sidebar-icon"></i>
                                    <span class="sidebar-text">{{ __('Liste') }}</span>
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('events.canceled') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 event-link {{ request()->routeIs('events.canceled') ? 'active' : '' }}">
                                    <i class="bi bi-list-ul me-2 text-danger sidebar-icon"></i>
                                    <span class="sidebar-text">{{ __('Événements annulés') }}</span>
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('events.passed') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 event-link {{ request()->routeIs('events.passed') ? 'active' : '' }}">
                                    <i class="bi bi-list-ul me-2 text-gray-500 sidebar-icon"></i>
                                    <span class="sidebar-text">{{ __('Événements passés') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('events.create') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 event-link {{ request()->routeIs('evenements.create') ? 'active' : '' }}">
                                    <i class="bi bi-plus-circle me-2 text-success sidebar-icon"></i>
                                    <span class="sidebar-text">{{ __('Ajouter') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
    
            @if(Auth::user()->role === 'admin')
                {{-- Paramètres --}}
                <li class="mb-2">
                    <div class="dropdown">
                        <a href="#" class="text-dark text-decoration-none d-flex align-items-center justify-content-between p-2 dropdown-toggle settings-link" data-bs-toggle="collapse" data-bs-target="#parametresSubmenu" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-gear me-2 text-secondary sidebar-icon"></i>
                                <span class="sidebar-text">{{ __('Paramètres') }}</span>
                            </div>
                        </a>
                        <div class="collapse" id="parametresSubmenu">
                            <ul class="list-unstyled ps-4 py-2">
                                <li class="mb-1">
                                    <a href="{{ route('categories') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 settings-link {{ request()->routeIs('categories') ? 'active' : '' }}">
                                        <i class="bi bi-tags me-2 text-secondary sidebar-icon"></i>
                                        <span class="sidebar-text">{{ __('Catégories') }}</span>
                                    </a>
                                </li>
                                <li class="mb-1">
                                    <a href="{{ route('regions') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 settings-link {{ request()->routeIs('regions') ? 'active' : '' }}">
                                        <i class="bi bi-globe me-2 text-secondary sidebar-icon"></i>
                                        <span class="sidebar-text">{{ __('Régions') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('cities') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 settings-link {{ request()->routeIs('villes') ? 'active' : '' }}">
                                        <i class="bi bi-building me-2 text-secondary sidebar-icon"></i>
                                        <span class="sidebar-text">{{ __('Villes') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('applications') }}" class="text-dark text-decoration-none d-flex align-items-center py-2 px-2 settings-link {{ request()->routeIs('applications') ? 'active' : '' }}">
                                        <i class="bi bi-grid-3x3-gap me-2 text-secondary sidebar-icon"></i>
                                        <span class="sidebar-text">{{ __('Applications') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            @endif
        </ul>

        <div class="border-top mt-auto">
            <div class="p-3">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle w-100 text-start" type="button" id="mobileUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2 text-black"></i>
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="mobileUserDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2 text-black"></i>
                                {{ __('Profil') }}
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2 text-black"></i>
                                    {{ __('Déconnexion') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add these styles to your CSS */
    .wrapper {
        display: flex;
        width: 100%;
    }

    .content-wrapper {
        width: calc(100% - 250px);
        margin-left: 250px;
        min-height: 100vh;
        background-color: #f8f9fa;
        transition: all 0.3s;
    }

    #sidebar {
        z-index: 999;
        transition: all 0.3s;
    }

    #sidebar .active {
        background-color: #f3f4f6;
        border-radius: 5px;
        /* color: lightgrey !important; */
        color: #333 !important;
    }

    #sidebar a:hover {
        background-color: #f3f4f6;
        border-radius: 5px;
        color: #lightgrey !important;
    }

    /* Collapsed sidebar styles */
    #sidebar.collapsed {
        width: 70px !important;
    }

    #sidebar.collapsed .sidebar-text {
        display: none;
    }

    #sidebar.collapsed .sidebar-logo {
        width: 100%;
    }

    #sidebar.collapsed .dropdown-toggle::after {
        display: none;
    }

    #sidebar.collapsed .collapse {
        display: none !important;
    }

    #sidebar.collapsed .dropdown-menu {
        position: fixed !important;
        left: 70px !important;
        top: auto !important;
        transform: none !important;
        margin-top: 0 !important;
        min-width: 200px;
    }

    #sidebar.collapsed .sidebar-footer .dropdown-menu {
        position: fixed !important;
        left: 70px !important;
        bottom: 20px !important;
        top: auto !important;
        transform: none !important;
        margin-top: 0 !important;
        min-width: 200px;
        margin-bottom: 0 !important;
    }

    #sidebar.collapsed #sidebarToggle i {
        transform: rotate(180deg);
    }

    #sidebar.collapsed .sidebar-header {
        padding: 1rem 0.5rem !important;
        text-align: center;
    }

    #sidebar.collapsed .sidebar-header a {
        justify-content: center !important;
    }

    /* Tooltip for collapsed sidebar */
    #sidebar.collapsed a[title] {
        position: relative;
    }

    #sidebar.collapsed a[title]:hover::after {
        content: attr(title);
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 1000;
        margin-left: 10px;
    }

    /* Adjust content when sidebar is collapsed */
    .content-wrapper.expanded {
        width: calc(100% - 70px);
        margin-left: 70px;
    }

    /* Mobile Styles */
    @media (max-width: 767.98px) {
        .content-wrapper {
            width: 100%;
            margin-left: 0;
            padding-top: 60px; /* Height of mobile header */
        }
        
        .offcanvas {
            width: 280px;
        }

        .offcanvas-body {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 60px);
        }

        .offcanvas-body .components {
            flex: 1;
        }

        /* Hide toggle button on mobile */
        #sidebarToggle {
            display: none;
        }
    }

    #sidebar {
        width: 250px;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        z-index: 999;
        background: #fff;
        transition: width 0.3s;
    }
    #sidebar.collapsed {
        width: 70px !important;
    }
    .sidebar-toggle-btn {
        position: fixed;
        top: 50px;
        left: 250px;
        z-index: 1100;
        width: 40px;
        height: 40px;
        border-radius: 10%;
        background: #3949AB;
        color: #fff;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: left 0.3s;
    }
    #sidebar.collapsed ~ .sidebar-toggle-btn {
        left: 70px;
    }
    .sidebar-toggle-btn:focus {
        outline: none;
    }
    .sidebar-toggle-btn i {
        font-size: 1.2rem;
        transition: transform 0.3s;
    }
    #sidebar.collapsed ~ .sidebar-toggle-btn i {
        transform: rotate(180deg);
    }

    /* Colored link backgrounds with opacity */
    .organizer-link {
        transition: background-color 0.3s ease;
    }

    .organizer-link:hover {
        background-color: rgba(13, 202, 240, 0.1) !important;
        border-radius: 5px;
    }

    .event-link {
        transition: background-color 0.3s ease;
    }

    .event-link:hover {
        background-color: rgba(25, 135, 84, 0.1) !important;
        border-radius: 5px;
    }

    .settings-link {
        transition: background-color 0.3s ease;
    }

    .settings-link:hover {
        background-color: rgba(108, 117, 125, 0.1) !important;
        border-radius: 5px;
    }

    /* Active state colors */
    .organizer-link.active {
        background-color: rgba(13, 202, 240, 0.15) !important;
        border-radius: 5px;
    }

    .event-link.active {
        background-color: rgba(25, 135, 84, 0.15) !important;
        border-radius: 5px;
    }

    .settings-link.active {
        background-color: rgba(108, 117, 125, 0.15) !important;
        border-radius: 5px;
    }

    /* Profile dropdown improvements */
    .sidebar-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        border-top: 1px solid #dee2e6;
        z-index: 1000;
    }

    .sidebar-footer .dropdown-menu {
        position: absolute;
        bottom: 100%;
        left: 0;
        margin-bottom: 0.5rem;
        min-width: 200px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    #sidebar.collapsed .sidebar-footer .dropdown-menu {
        position: fixed !important;
        left: 70px !important;
        bottom: 20px !important;
        top: auto !important;
        transform: none !important;
        margin-top: 0 !important;
        min-width: 200px;
        margin-bottom: 0 !important;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check current route and open appropriate dropdown
    const currentRoute = '{{ request()->route()->getName() }}';
    
    // Open parameters dropdown if on categories, regions, or cities pages
    if (currentRoute === 'categories' || currentRoute === 'regions' || currentRoute === 'cities' || currentRoute === 'applications') {
        const parametresSubmenu = document.getElementById('parametresSubmenu');
        if (parametresSubmenu) {
            parametresSubmenu.classList.add('show');
            
            // Update aria-expanded attribute
            const parametresToggle = document.querySelector('[data-bs-target="#parametresSubmenu"]');
            if (parametresToggle) {
                parametresToggle.setAttribute('aria-expanded', 'true');
            }
        }
    }
    
    // For example, if you have organizer pages:
    if (currentRoute === 'organizers' || currentRoute === 'organizers.create') {
        const organisateursSubmenu = document.getElementById('organisateursSubmenu');
        if (organisateursSubmenu) {
            organisateursSubmenu.classList.add('show');
            const organisateursToggle = document.querySelector('[data-bs-target="#organisateursSubmenu"]');
            if (organisateursToggle) {
                organisateursToggle.setAttribute('aria-expanded', 'true');
            }
        }
    }
    
    // For event pages:
    if (currentRoute === 'events' || currentRoute === 'events.create' || currentRoute === 'passedEvents' || currentRoute === 'canceledEvents') {
        const evenementsSubmenu = document.getElementById('evenementsSubmenu');
        if (evenementsSubmenu) {
            evenementsSubmenu.classList.add('show');
            const evenementsToggle = document.querySelector('[data-bs-target="#evenementsSubmenu"]');
            if (evenementsToggle) {
                evenementsToggle.setAttribute('aria-expanded', 'true');
            }
        }
    }
});
</script>
