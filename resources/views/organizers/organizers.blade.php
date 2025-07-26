<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Organisateurs') }}
            </h2>
            <a href="{{ route('organizers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Ajouter un organisateur
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __("Nom d'organisateur") }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Organisme organisateur') }}</th>
                                    <th scope="col">{{ __('Téléphone') }}</th>
                                    <th scope="col">{{ __('Statut du compte') }}</th>
                                    <th scope="col">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($organizers as $organizer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-info bg-opacity-10 rounded-circle me-2" style="padding: 0.5rem 0.7rem;">
                                                    <i class="bi bi-person-gear text-info"></i>
                                                </div>
                                                <span class="fw-medium">{{ $organizer->user ? $organizer->user->name : '-' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $organizer->user ? $organizer->user->email : '-' }}</td>
                                        <td>{{ $organizer->title }}</td>
                                        <td>{{ $organizer->phone_numbre }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('organizers.updateStatus', $organizer) }}" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm d-inline w-auto status-select {{ $organizer->user && $organizer->user->status === 'active' ? 'status-actif' : 'status-inactif' }}" onchange="updateStatusColor(this); this.form.submit();">
                                                    <option value="active" {{ $organizer->user && $organizer->user->status === 'active' ? 'selected' : '' }}>Actif</option>
                                                    <option value="deactive" {{ $organizer->user && $organizer->user->status !== 'active' ? 'selected' : '' }}>Inactif</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-info" title="Voir" data-bs-toggle="modal" data-bs-target="#organizerModal{{ $organizer->id }}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <!-- Organizer Detail Modal -->
                                            <div class="modal fade" id="organizerModal{{ $organizer->id }}" tabindex="-1" aria-labelledby="organizerModalLabel{{ $organizer->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header border-0 pb-2 bg-info bg-opacity-10">
                                                            <h5 class="modal-title fw-bold" id="organizerModalLabel{{ $organizer->id }}">Détails de l'organisateur</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body py-4">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                                                    @if($organizer->image)
                                                                        <img src="{{ asset('images/organizers/' . $organizer->image) }}" alt="Image" class="img-fluid rounded shadow" style="max-height: 180px; object-fit: cover;">
                                                                    @else
                                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 180px;">
                                                                            <i class="bi bi-person-circle text-secondary" style="font-size: 4rem;"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="mb-2">
                                                                        <span class="fw-semibold text-secondary">Nom d'organisateur :</span>
                                                                        <span class="ms-2">{{ $organizer->user ? $organizer->user->name : '-' }}</span>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <span class="fw-semibold text-secondary">Email :</span>
                                                                        <span class="ms-2">{{ $organizer->user ? $organizer->user->email : '-' }}</span>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <span class="fw-semibold text-secondary">Téléphone :</span>
                                                                        <span class="ms-2">{{ $organizer->phone_numbre }}</span>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <span class="fw-semibold text-secondary">Organisme organisateur :</span>
                                                                        <span class="ms-2">{{ $organizer->title }}</span>
                                                                    </div>
                                                                    <div class="mt-4">
                                                                        <a href="#" class="btn btn-outline-info">
                                                                            <i class="bi bi-calendar-event me-1"></i> Voir events
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                                {{ __('Aucun organisateur trouvé.') }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
        .status-select {
            border: none;
            border-radius: 1.5rem;
            font-weight: 600;
            padding: 0.25rem 1.2rem 0.25rem 1.2rem;
            min-width: 90px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 0 0; /* Hide arrow */
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            transition: background 0.2s, color 0.2s;
            cursor: pointer;
        }
        .status-actif {
            background: #e6f9ed;
            color: #198754;
        }
        .status-inactif {
            background: #fff5f5;
            color: #dc3545;
        }
        .status-select:focus {
            outline: none;
            box-shadow: 0 0 0 2px #b6f0d3;
        }
        .status-select option {
            color: #222;
        }
        .modal-content {
            border-radius: 1.1rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
        }
        .modal-title {
            font-size: 1.35rem;
            font-weight: 700;
        }
        .modal-body {
            background: #f8fafc;
        }
        .modal-body .fw-semibold {
            font-size: 1.08rem;
        }
        .modal-body .btn-outline-info {
            font-weight: 500;
            border-radius: 1.5rem;
            padding-left: 1.2rem;
            padding-right: 1.2rem;
        }
        .modal-body img.img-fluid {
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
    </style>
    <script>
        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('show');
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const successToast = document.getElementById('successToast');
            const errorToast = document.getElementById('errorToast');
            if (successToast) {
                setTimeout(() => { successToast.classList.add('show'); }, 100);
                setTimeout(() => { successToast.classList.remove('show'); }, 5000);
            }
            if (errorToast) {
                setTimeout(() => { errorToast.classList.add('show'); }, 100);
                setTimeout(() => { errorToast.classList.remove('show'); }, 5000);
            }
        });
        function updateStatusColor(select) {
            select.classList.remove('status-actif', 'status-inactif');
            if (select.value === 'active') {
                select.classList.add('status-actif');
            } else {
                select.classList.add('status-inactif');
            }
        }
    </script>
</x-app-layout>
