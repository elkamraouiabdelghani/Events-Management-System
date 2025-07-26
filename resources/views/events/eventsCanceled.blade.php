<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Événements annulés') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-4">
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
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->city->name ?? 'N/A' }}</td>
                                    <td class="event-place-cell">{{ $event->place }}</td>
                                    <td>{{ $event->date }}</td>
                                    <td>{{ $event->time }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-info" title="Voir" data-bs-toggle="modal" data-bs-target="#viewCanceledEventModal{{ $event->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- View Modal -->
                                <div class="modal fade" id="viewCanceledEventModal{{ $event->id }}" tabindex="-1" aria-labelledby="viewCanceledEventModalLabel{{ $event->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewCanceledEventModalLabel{{ $event->id }}">
                                                    <i class="bi bi-calendar2-x me-2 text-danger"></i>Détails de l'événement annulé
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if($event->image)
                                                            <div class="text-center mb-3">
                                                                <img src="{{ asset('images/events/' . $event->image) }}" alt="Image de l'événement" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
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
                                                        <h4 class="fw-bold text-danger mb-3">{{ $event->title }}</h4>
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold text-muted mb-2">Description</h6>
                                                            <p class="text-muted">{{ $event->description }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <span class="badge bg-danger bg-opacity-10 text-danger">Annulé</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-3 mt-3">
                                                    <div class="col-md-6">
                                                        <div class="bg-light rounded p-3">
                                                            <h6 class="fw-semibold text-muted mb-2"><i class="bi bi-tag me-2"></i>Catégorie</h6>
                                                            <p class="mb-0">{{ $event->category->name ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="bg-light rounded p-3">
                                                            <h6 class="fw-semibold text-muted mb-2"><i class="bi bi-geo-alt me-2"></i>Localisation</h6>
                                                            <p class="mb-0">{{ $event->region->name ?? 'N/A' }} - {{ $event->city->name ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="bg-light rounded p-3">
                                                            <h6 class="fw-semibold text-muted mb-2"><i class="bi bi-calendar me-2"></i>Date et heure</h6>
                                                            <p class="mb-0">{{ $event->date }} à {{ $event->time }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="bg-light rounded p-3">
                                                            <h6 class="fw-semibold text-muted mb-2"><i class="bi bi-building me-2"></i>Lieu</h6>
                                                            <p class="mb-0">{{ $event->place }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="bg-light rounded p-3">
                                                            <h6 class="fw-semibold text-muted mb-2"><i class="bi bi-person-gear me-2"></i>Organisateur</h6>
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
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                        {{ __('Aucun événement annulé trouvé') }}
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
        .event-place-cell {
            max-width: 120px;
            width: 20%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</x-app-layout>
