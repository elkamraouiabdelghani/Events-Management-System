@php
    use Illuminate\Support\Str;
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tableau de bord') }}
            </h2>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(Auth::user()->role === 'organizer')
                    {{ __('Organisateur') }}
                @else
                    {{ ucfirst(Auth::user()->role) }}
                @endif
            </h2>
        </div>
    </x-slot>

    @if(session('success'))
        <div id="successToast" class="toast-notification success">
            <div class="toast-content">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
            <button type="button" class="toast-close" onclick="closeToast('successToast')">
                <i class="bi bi-x"></i>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div id="errorToast" class="toast-notification error">
            <div class="toast-content">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('error') }}
            </div>
            <button type="button" class="toast-close" onclick="closeToast('errorToast')">
                <i class="bi bi-x"></i>
            </button>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Section -->
            <div class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Admin Statistics -->
                    @if(Auth::user()->role === 'admin')
                    <!-- Categories Card -->
                        <div class="bg-white shadow rounded-md transition-transform hover:scale-105 duration-200">
                            <div class="p-6 flex flex-col justify-between h-full">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-primary bg-opacity-10" style="padding-top: 1rem;padding-left: 1.2rem;padding-right: 1.2rem;padding-bottom: 1rem;">
                                        <i class="bi bi-tags text-2xl text-primary"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-600">{{ __('Catégories') }}</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $categoriesCount ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('categories') }}" class="text-sm text-primary hover:text-primary-dark flex items-center font-semibold">
                                        {{ __('Voir toutes les catégories') }}
                                        <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Regions Card -->
                        <div class="bg-white shadow rounded-md transition-transform hover:scale-105 duration-200">
                            <div class="p-6 flex flex-col justify-between h-full">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-warning bg-opacity-10" style="padding-top: 1rem;padding-left: 1.2rem;padding-right: 1.2rem;padding-bottom: 1rem;">
                                        <i class="bi bi-globe text-2xl text-warning"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-600">{{ __('Régions') }}</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $regionsCount ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('regions') }}" class="text-sm text-warning hover:text-warning-dark flex items-center font-semibold">
                                        {{ __('Voir toutes les régions') }}
                                        <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Cities Card -->
                        <div class="bg-white shadow rounded-md transition-transform hover:scale-105 duration-200">
                            <div class="p-6 flex flex-col justify-between h-full">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-secondary bg-opacity-10" style="padding-top: 1rem;padding-left: 1.2rem;padding-right: 1.2rem;padding-bottom: 1rem;">
                                        <i class="bi bi-building text-2xl text-secondary"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-600">{{ __('Villes') }}</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $citiesCount ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('cities') }}" class="text-sm text-secondary hover:text-secondary-dark flex items-center font-semibold">
                                        {{ __('Voir toutes les villes') }}
                                        <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Events Card -->
                        <div class="bg-white shadow rounded-md transition-transform hover:scale-105 duration-200">
                            <div class="p-6 flex flex-col justify-between h-full">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-success bg-opacity-10" style="padding-top: 1rem;padding-left: 1.2rem;padding-right: 1.2rem;padding-bottom: 1rem;">
                                        <i class="bi bi-calendar-event text-2xl text-success"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-600">{{ __('Événements') }}</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $eventsCount ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('events') }}" class="text-sm text-success hover:text-success-dark flex items-center font-semibold">
                                        {{ __('Voir tous les événements') }}
                                        <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Organizers Card -->
                        <div class="bg-white shadow rounded-md transition-transform hover:scale-105 duration-200">
                            <div class="p-6 flex flex-col justify-between h-full">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-info bg-opacity-10" style="padding-top: 1rem;padding-left: 1.2rem;padding-right: 1.2rem;padding-bottom: 1rem;">
                                        <i class="bi bi-person-gear text-2xl text-info"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-600">{{ __('Organisateurs') }}</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $organizersCount ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('organizers') }}" class="text-sm text-info hover:text-info-dark flex items-center font-semibold">
                                        {{ __('Voir tous les organisateurs') }}
                                        <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    <!-- Organizer Statistics -->
                    @elseif(Auth::user()->role === 'organizer')
                        <!-- Future Events Card -->
                        <div class="bg-white shadow rounded-md transition-transform hover:scale-105 duration-200">
                            <div class="p-6 flex flex-col justify-between h-full">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-success bg-opacity-10" style="padding-top: 1rem;padding-left: 1.2rem;padding-right: 1.2rem;padding-bottom: 1rem;">
                                        <i class="bi bi-calendar-plus text-2xl text-success"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-600">{{ __('Événements à venir') }}</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $futureEventsCount ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('events') }}" class="text-sm text-success hover:text-success-dark flex items-center font-semibold">
                                        {{ __('Voir les événements à venir') }}
                                        <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Passed Events Card -->
                        <div class="bg-white shadow rounded-md transition-transform hover:scale-105 duration-200">
                            <div class="p-6 flex flex-col justify-between h-full">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-secondary bg-opacity-10" style="padding-top: 1rem;padding-left: 1.2rem;padding-right: 1.2rem;padding-bottom: 1rem;">
                                        <i class="bi bi-calendar-check text-2xl text-secondary"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-600">{{ __('Événements passés') }}</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $passedEventsCount ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('events.passed') }}" class="text-sm text-secondary hover:text-secondary-dark flex items-center font-semibold">
                                        {{ __('Voir les événements passés') }}
                                        <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Canceled Events Card -->
                        <div class="bg-white shadow rounded-md transition-transform hover:scale-105 duration-200">
                            <div class="p-6 flex flex-col justify-between h-full">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-danger bg-opacity-10" style="padding-top: 1rem;padding-left: 1.2rem;padding-right: 1.2rem;padding-bottom: 1rem;">
                                        <i class="bi bi-calendar-x text-2xl text-danger"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-600">{{ __('Événements annulés') }}</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ $canceledEventsCount ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('events.canceled') }}" class="text-sm text-danger hover:text-danger-dark flex items-center font-semibold">
                                        {{ __('Voir les événements annulés') }}
                                        <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Total Events Card -->
                        <div class="bg-white shadow rounded-md transition-transform hover:scale-105 duration-200">
                            <div class="p-6 flex flex-col justify-between h-full">
                                <div class="flex items-center">
                                    <div class="rounded-full bg-primary bg-opacity-10" style="padding-top: 1rem;padding-left: 1.2rem;padding-right: 1.2rem;padding-bottom: 1rem;">
                                        <i class="bi bi-calendar-event text-2xl text-primary"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-600">{{ __('Total des événements') }}</p>
                                        <p class="text-2xl font-bold text-gray-900">{{ ($futureEventsCount ?? 0) + ($passedEventsCount ?? 0) + ($canceledEventsCount ?? 0) }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('events') }}" class="text-sm text-primary hover:text-primary-dark flex items-center font-semibold">
                                        {{ __('Voir tous mes événements') }}
                                        <i class="bi bi-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- latest new and updated events --}}
            @if(isset($newEvents) && $newEvents->count())
            <div class="bg-white shadow rounded-md mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="bi bi-stars text-primary mr-2"></i>
                        @if(Auth::user()->role === 'admin')
                            {{ __('Événements à publier') }}
                        @else
                            {{ __('Mes événements à publier') }}
                        @endif
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Titre') }}</th>
                                    <th scope="col">{{ __('Ville') }}</th>
                                    <th scope="col">{{ __('Lieu') }}</th>
                                    <th scope="col">{{ __('Date') }}</th>
                                    <th scope="col">{{ __('Heure') }}</th>
                                    <th scope="col">{{ __('Statut') }}</th>
                                    <th scope="col">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($newEvents as $event)
                                    <tr>
                                        <td>{{ ($newEvents->currentPage() - 1) * $newEvents->perPage() + $loop->iteration }}</td>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->city->name ?? '-' }}</td>
                                        <td class="event-place-cell">{{ $event->place }}</td>
                                        <td>{{ $event->date }}</td>
                                        <td>{{ $event->time }}</td>
                                        <td>
                                            @if(Auth::user()->role === 'admin' && in_array($event->status, ['new', 'updated']))
                                                <form action="{{ route('events.updateStatus', $event) }}" method="POST" class="d-inline-flex align-items-center">
                                                    @method('PUT')
                                                    @csrf
                                                    <select name="status" class="form-select form-select-sm me-2 border-0 no-arrow @if($event->status == 'new') bg-info @elseif($event->status == 'updated') bg-warning @endif bg-opacity-10" onchange="this.form.submit()">
                                                        <option value="{{ $event->status }}">{{ ucfirst($event->status) }}</option>
                                                        <option value="publish">Publish</option>
                                                    </select>
                                                </form>
                                            @else
                                                <span class="badge 
                                                    @switch($event->status)
                                                        @case('new')
                                                            bg-info
                                                            @break
                                                        @case('updated')
                                                            bg-warning
                                                            @break
                                                        @default
                                                            bg-secondary
                                                    @endswitch bg-opacity-10 text-black">
                                                    {{ ucfirst($event->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-info" title="Voir" data-bs-toggle="modal" data-bs-target="#viewEventModal{{ $event->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @if(Auth::user()->role === 'admin')
                                                <button type="button" class="btn btn-sm btn-outline-primary" title="Organisateur" data-bs-toggle="modal" data-bs-target="#viewOrganizerModal{{ $event->id }}">
                                                    <i class="bi bi-person-badge"></i>
                                                </button>
                                            @endif
                                            @if(Auth::user()->role === 'organizer' && isset($event->organizer_id) && Auth::user()->organizer && Auth::user()->organizer->id === $event->organizer_id && !in_array($event->status, ['canceled', 'passed']))
                                                <form action="{{ route('events.updateStatus', $event) }}" method="POST" class="d-inline" id="cancelEventFormDashboard{{ $event->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="canceled">
                                                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" data-bs-toggle="modal" data-bs-target="#cancelEventModalDashboard{{ $event->id }}" title="Annuler l'événement">
                                                        <i class="bi bi-x-octagon"></i>
                                                    </button>
                                                </form>
                                                <!-- Cancel Confirmation Modal -->
                                                <div class="modal fade" id="cancelEventModalDashboard{{ $event->id }}" tabindex="-1" aria-labelledby="cancelEventModalDashboardLabel{{ $event->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="cancelEventModalDashboardLabel{{ $event->id }}">
                                                                    <i class="bi bi-x-octagon text-danger me-2"></i>Confirmer l'annulation
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Êtes-vous sûr de vouloir annuler cet événement ? Cette action est <span class="fw-bold text-danger">irréversible</span>.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non, garder l'événement</button>
                                                                <button type="button" class="btn btn-danger" onclick="document.getElementById('cancelEventFormDashboard{{ $event->id }}').submit();">Oui, annuler</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- View Event Modal -->
                                    <div class="modal fade" id="viewEventModal{{ $event->id }}" tabindex="-1" aria-labelledby="viewEventModalLabel{{ $event->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewEventModalLabel{{ $event->id }}">
                                                        <i class="bi bi-calendar2-event me-2 text-primary"></i>
                                                        Détails de l'événement
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            @if($event->image)
                                                                <div class="text-center mb-3">
                                                                    <img src="{{ asset('images/events/' . $event->image) }}" 
                                                                        alt="Image de l'événement" 
                                                                        class="img-fluid rounded shadow-sm" 
                                                                        style="max-height: 300px; object-fit: cover;">
                                                                </div>
                                                            @else
                                                                <div class="text-center mb-3">
                                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                                                        <i class="bi bi-image text-muted display-4"></i>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h4 class="fw-bold text-primary mb-3">{{ $event->title }}</h4>
                                                            <div class="mb-3">
                                                                <span class="badge 
                                                                    @switch($event->status)
                                                                        @case('new')
                                                                            bg-info
                                                                            @break
                                                                        @case('publish')
                                                                            bg-success
                                                                            @break
                                                                        @case('updated')
                                                                            bg-purple
                                                                            @break
                                                                        @case('passed')
                                                                            bg-secondary
                                                                            @break
                                                                        @case('canceled')
                                                                            bg-danger
                                                                            @break
                                                                        @default
                                                                            bg-secondary
                                                                    @endswitch bg-opacity-10 text-black">
                                                                    {{ ucfirst($event->status) }}
                                                                </span>
                                                            </div>
                                                            <div class="mb-3">
                                                                <h6 class="fw-semibold text-muted mb-2">Description</h6>
                                                                <p class="text-muted">{{ $event->description }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-3 mt-3">
                                                        <div class="col-md-6">
                                                            <div class="bg-light rounded p-3">
                                                                <h6 class="fw-semibold text-muted mb-2">
                                                                    <i class="bi bi-tag me-2"></i>Catégorie
                                                                </h6>
                                                                <p class="mb-0">{{ $event->category->name ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="bg-light rounded p-3">
                                                                <h6 class="fw-semibold text-muted mb-2">
                                                                    <i class="bi bi-geo-alt me-2"></i>Localisation
                                                                </h6>
                                                                <p class="mb-0">{{ $event->region->name ?? 'N/A' }} - {{ $event->city->name ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="bg-light rounded p-3">
                                                                <h6 class="fw-semibold text-muted mb-2">
                                                                    <i class="bi bi-calendar me-2"></i>Date et heure
                                                                </h6>
                                                                <p class="mb-0">{{ $event->date }} à {{ $event->time }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="bg-light rounded p-3">
                                                                <h6 class="fw-semibold text-muted mb-2">
                                                                    <i class="bi bi-building me-2"></i>Lieu
                                                                </h6>
                                                                <p class="mb-0">{{ $event->place }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="bg-light rounded p-3">
                                                                <h6 class="fw-semibold text-muted mb-2">
                                                                    <i class="bi bi-person-gear me-2"></i>Organisateur
                                                                </h6>
                                                                <p class="mb-0">{{ $event->organizer->title ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- View Organizer Modal -->
                                    <div class="modal fade" id="viewOrganizerModal{{ $event->id }}" tabindex="-1" aria-labelledby="viewOrganizerModalLabel{{ $event->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewOrganizerModalLabel{{ $event->id }}">
                                                        <i class="bi bi-person-badge me-2 text-primary"></i>
                                                        Informations de l'organisateur
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($event->organizer)
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                @if($event->organizer->image)
                                                                    <div class="text-center mb-3">
                                                                        <img src="{{ asset('images/organizers/' . $event->organizer->image) }}" 
                                                                            alt="Image de l'organisateur" 
                                                                            class="img-fluid rounded shadow-sm" 
                                                                            style="max-height: 200px; object-fit: cover;">
                                                                    </div>
                                                                @else
                                                                    <div class="text-center mb-3">
                                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                                                            <i class="bi bi-person-circle text-muted display-4"></i>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h4 class="fw-bold text-primary mb-3">{{ $event->organizer->title }}</h4>
                                                                @if($event->organizer->description)
                                                                    <div class="mb-3">
                                                                        <h6 class="fw-semibold text-muted mb-2">Description</h6>
                                                                        <p class="text-muted">{{ $event->organizer->description }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="row g-3 mt-3">
                                                            @if($event->organizer->phone_numbre)
                                                                <div class="col-md-6">
                                                                    <div class="bg-light rounded p-3">
                                                                        <h6 class="fw-semibold text-muted mb-2">
                                                                            <i class="bi bi-telephone me-2"></i>Téléphone
                                                                        </h6>
                                                                        <p class="mb-0">{{ $event->organizer->phone_numbre }}</p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if($event->organizer->user)
                                                                <div class="col-md-6">
                                                                    <div class="bg-light rounded p-3">
                                                                        <h6 class="fw-semibold text-muted mb-2">
                                                                            <i class="bi bi-envelope me-2"></i>Email
                                                                        </h6>
                                                                        <p class="mb-0">{{ $event->organizer->user->email }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="bg-light rounded p-3">
                                                                        <h6 class="fw-semibold text-muted mb-2">
                                                                            <i class="bi bi-person me-2"></i>Nom complet
                                                                        </h6>
                                                                        <p class="mb-0">{{ $event->organizer->user->name }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="bg-light rounded p-3">
                                                                        <h6 class="fw-semibold text-muted mb-2">
                                                                            <i class="bi bi-shield-check me-2"></i>Statut de compte
                                                                        </h6>
                                                                        <p class="mb-0">
                                                                            <span class="badge 
                                                                                @if($event->organizer->user->status === 'active')
                                                                                    bg-success
                                                                                @else
                                                                                    bg-warning
                                                                                @endif bg-opacity-10 text-black">
                                                                                {{ ucfirst($event->organizer->user->status ?? 'inactive') }}
                                                                            </span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="col-12">
                                                                <div class="bg-light rounded p-3">
                                                                    <h6 class="fw-semibold text-muted mb-2">
                                                                        <i class="bi bi-calendar-event me-2"></i>Événements organisés
                                                                    </h6>
                                                                    <p class="mb-0">{{ $event->organizer->events->count() }} événement(s)</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-center py-4">
                                                            <i class="bi bi-exclamation-triangle text-warning display-4 mb-3"></i>
                                                            <h5 class="text-muted">Aucune information d'organisateur disponible</h5>
                                                            <p class="text-muted">L'organisateur de cet événement n'a pas été trouvé.</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">{{ __('Aucun nouvel événement trouvé.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-4">
                        {{ $newEvents->links() }}
                    </div>
                </div>
            </div>
            @endif

            {{-- line graph --}}
            <div class="bg-white shadow rounded-md mb-6">
                <div class="p-6">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="bi bi-graph-up-arrow text-primary mr-1"></i>
                            {{ __('Évolution des événements créés par mois') }}
                        </h3>
                        <form method="GET" action="" class="d-flex align-items-center" style="max-width: 250px;">
                            <select name="year" id="yearSelect" class="form-select form-select-sm" onchange="this.form.submit()">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" @if($year == $selectedYear) selected @endif>{{ $year }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <canvas id="eventsLineChart" height="80"></canvas>
                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        @if(Auth::user()->role === 'admin')
                            {{ __('Activité récente') }}
                        @else
                            {{ __('Mes événements récents') }}
                        @endif
                    </h3>
                    <div class="text-gray-600">
                        @if(Auth::user()->role === 'admin')
                            {{ __("Vous êtes connecté en tant qu'administrateur !") }}
                        @else
                            {{ __("Bienvenue dans votre espace organisateur !") }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .grid {
            display: grid;
        }
        
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        
        @media (min-width: 1024px) {
            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
        
        .gap-6 {
            gap: 1.5rem;
        }
        .no-arrow {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none !important;
            padding-right: 1rem !important;
            border-radius: 0.75rem !important;
        }
        .toast-notification {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            min-width: 300px;
            max-width: 400px;
            z-index: 9999;
            border-left: 4px solid;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s, transform 0.3s;
        }
        .toast-notification.show {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }
        .toast-notification.success { border-left-color: #28a745; }
        .toast-notification.success .toast-content i { color: #28a745; }
        .toast-notification.error { border-left-color: #dc3545; }
        .toast-notification.error .toast-content i { color: #dc3545; }
        .toast-content { display: flex; align-items: center; flex: 1; font-size: 15px; color: #333; }
        .toast-close { background: none; border: none; color: #666; cursor: pointer; padding: 4px; border-radius: 4px; transition: background-color 0.2s; }
        .toast-close:hover { background-color: #f0f0f0; color: #333; }
        @media (max-width: 768px) {
            .toast-notification { bottom: 10px; right: 10px; left: 10px; min-width: auto; max-width: none; }
        }
        .event-place-cell {
            max-width: 150px;
            width: 15%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Pagination Styles */
        .pagination {
            margin-bottom: 0;
        }
        .pagination .page-link {
            border: none;
            color: #6c757d;
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        .pagination .page-link:hover {
            background-color: #e9ecef;
            color: #495057;
            transform: translateY(-1px);
        }
        .pagination .page-item.active .page-link {
            background-color: #2563eb;
            border-color: #2563eb;
            color: white;
        }
        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: transparent;
        }
    </style>
    <script>
        function closeToast(id) {
            var toast = document.getElementById(id);
            if (toast) toast.style.opacity = 0;
        }
        window.addEventListener('DOMContentLoaded', function() {
            var successToast = document.getElementById('successToast');
            var errorToast = document.getElementById('errorToast');
            if (successToast) {
                setTimeout(function() { successToast.classList.remove('show'); }, 5000);
                setTimeout(function() { successToast.style.opacity = 0; }, 5200);
                successToast.classList.add('show');
            }
            if (errorToast) {
                setTimeout(function() { errorToast.classList.remove('show'); }, 5000);
                setTimeout(function() { errorToast.style.opacity = 0; }, 5200);
                errorToast.classList.add('show');
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('eventsLineChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($eventsPerMonthData->pluck('month')->map(function($m){return \Carbon\Carbon::createFromFormat('Y-m', $m)->translatedFormat('M Y');})) !!},
                    datasets: [{
                        label: 'Événements créés',
                        data: {!! json_encode($eventsPerMonthData->pluck('count')) !!},
                        fill: true,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37,99,235,0.08)',
                        tension: 0.3,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            title: { display: true, text: 'Mois' }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f3f4f6' },
                            title: { display: true, text: 'Nombre d\'événements' }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
