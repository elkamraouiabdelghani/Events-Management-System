<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
                {{ __('Versions précédentes de l\'événement') }}
            </h2>
            <a href="{{ route('events') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> {{ __('Retour à la liste') }}
            </a>
        </div>
    </x-slot>
    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-4">
                <h4 class="mb-4">Historique des versions de l'événement</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Titre</th>
                                <th>Catégorie</th>
                                <th>Région</th>
                                <th>Ville</th>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Organisateur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($eventVersions as $version)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $version->title }}</td>
                                    <td>{{ $version->category->name ?? 'N/A' }}</td>
                                    <td>{{ $version->region->name ?? 'N/A' }}</td>
                                    <td>{{ $version->city->name ?? 'N/A' }}</td>
                                    <td>{{ $version->date }}</td>
                                    <td>{{ $version->time }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($version->organizer && $version->organizer->image)
                                                <img src="{{ asset('images/organizers/' . $version->organizer->image) }}" alt="Image" class="rounded-circle me-2" style="width:32px;height:32px;object-fit:cover;">
                                            @else
                                                <i class="bi bi-person-circle text-muted fs-4 me-2"></i>
                                            @endif
                                            <span>{{ $version->organizer->title ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#versionModal{{ $version->id }}" title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Modal for version details -->
                                <div class="modal fade" id="versionModal{{ $version->id }}" tabindex="-1" aria-labelledby="versionModalLabel{{ $version->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="versionModalLabel{{ $version->id }}">
                                                    <i class="bi bi-clock-history me-2 text-primary"></i>
                                                    Détails de la version
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if($version->image)
                                                            <div class="text-center mb-3">
                                                                <img src="{{ asset('images/events/' . $version->image) }}" alt="Image de l'événement" class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
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
                                                        <h4 class="fw-bold text-primary mb-3">{{ $version->title }}</h4>
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold text-muted mb-2">Description</h6>
                                                            <p class="text-muted">{{ $version->description }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold text-muted mb-2">Catégorie</h6>
                                                            <p class="mb-0">{{ $version->category->name ?? 'N/A' }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold text-muted mb-2">Région / Ville</h6>
                                                            <p class="mb-0">{{ $version->region->name ?? 'N/A' }} - {{ $version->city->name ?? 'N/A' }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold text-muted mb-2">Lieu</h6>
                                                            <p class="mb-0">{{ $version->place }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold text-muted mb-2">Date et heure</h6>
                                                            <p class="mb-0">{{ $version->date }} à {{ $version->time }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6 class="fw-semibold text-muted mb-2">Organisateur</h6>
                                                            <p class="mb-0">{{ $version->organizer->title ?? 'N/A' }}</p>
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
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                        {{ __('Aucune version trouvée') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
