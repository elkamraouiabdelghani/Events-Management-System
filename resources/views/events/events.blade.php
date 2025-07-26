<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Événements') }}
            </h2>
            <a href="{{ route('events.create') }}" class="btn btn-primary d-flex align-items-center">
                <i class="bi bi-plus-circle me-2"></i> {{ __('Ajouter un événement') }}
            </a>
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

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" action="" class="mb-4 d-flex align-items-center" style="max-width: 400px;">
                    <input type="text" id="eventSearch" name="search" class="form-control rounded me-2" placeholder="Rechercher par titre..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
                </form>
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
                            @forelse($events as $event)
                                @if(in_array($event->status, ['new', 'publish', 'updated']))
                                    <tr class="event-row" data-title="{{ strtolower($event->title) }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->city->name }}</td>
                                        <td class="event-place-cell" title="{{ $event->place }}">{{ $event->place }}</td>
                                        <td>{{ $event->date }}</td>
                                        <td>{{ $event->time }}</td>
                                        <td>
                                            @if(Auth::user()->role === 'admin' && in_array($event->status, ['new', 'updated', 'publish']))
                                                <form action="{{ route('events.updateStatus', $event) }}" method="POST" class="d-inline-flex align-items-center">
                                                    @method('PUT')
                                                    @csrf
                                                    <select name="status" class="form-select form-select-sm me-2 border-0 no-arrow @if($event->status == 'new') bg-info @elseif($event->status == 'updated') bg-warning @elseif($event->status == 'publish') bg-success @endif bg-opacity-10" onchange="this.form.submit()">
                                                        <option value="{{ $event->status }}">{{ ucfirst($event->status) }}</option>
                                                        @if($event->status === 'new')
                                                            <option value="publish">Publish</option>
                                                            <option value="updated">Updated</option>
                                                        @elseif($event->status === 'updated')
                                                            <option value="publish">Publish</option>
                                                        @elseif($event->status === 'publish')
                                                            <option value="updated">Updated</option>
                                                        @endif
                                                    </select>
                                                </form>
                                            @else
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
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if($event->status === 'updated')
                                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-outline-info rounded" title="Modifier" data-bs-target="#viewEventModal{{ $event->id }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-info rounded" title="Voir" data-bs-toggle="modal" data-bs-target="#viewEventModal{{ $event->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                @endif
                                                @if(Auth::user()->role === 'admin')
                                                    <button type="button" class="btn btn-sm btn-outline-primary" title="Organisateur" data-bs-toggle="modal" data-bs-target="#viewOrganizerModal{{ $event->id }}">
                                                        <i class="bi bi-person-badge"></i>
                                                    </button>
                                                @endif
                                                @if(Auth::user()->role === 'organizer' && $event->status !== 'updated')
                                                    <form action="{{ route('events.requestUpdate', $event) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-sm btn-outline-warning d-flex align-items-center" title="Demander l'autorisation de modification">
                                                            <i class="bi bi-envelope-paper"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('events.versions', $event) }}" class="btn btn-sm btn-outline-secondary rounded" title="Voir les versions">
                                                    <i class="bi bi-clock-history"></i>
                                                </a>
                                                @if(Auth::user()->role === 'organizer' && isset($event->organizer_id) && Auth::user()->organizer && Auth::user()->organizer->id === $event->organizer_id && !in_array($event->status, ['canceled', 'passed']))
                                                    <form action="{{ route('events.updateStatus', $event) }}" method="POST" class="d-inline" id="cancelEventFormEvents{{ $event->id }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="canceled">
                                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelEventModalEvents{{ $event->id }}" title="Annuler l'événement">
                                                            <i class="bi bi-x-octagon"></i>
                                                        </button>
                                                    </form>
                                                    <!-- Cancel Confirmation Modal -->
                                                    <div class="modal fade" id="cancelEventModalEvents{{ $event->id }}" tabindex="-1" aria-labelledby="cancelEventModalEventsLabel{{ $event->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="cancelEventModalEventsLabel{{ $event->id }}">
                                                                        <i class="bi bi-x-octagon text-danger me-2"></i>Confirmer l'annulation
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Êtes-vous sûr de vouloir annuler cet événement ? Cette action est <span class="fw-bold text-danger">irréversible</span>.</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non, garder l'événement</button>
                                                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('cancelEventFormEvents{{ $event->id }}').submit();">Oui, annuler</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
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

                                    
                                @endif
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                        {{ __('Aucun événement trouvé') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
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
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('eventSearch');
    const rows = document.querySelectorAll('.event-row');
    function filterRows() {
        const value = searchInput.value.trim().toLowerCase();
        rows.forEach(row => {
            const title = row.getAttribute('data-title');
            if (value === '' || title.startsWith(value)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    searchInput.addEventListener('input', filterRows);
    // Trigger filtering on page load if search input is pre-filled
    filterRows();
});
</script>
</x-app-layout>
