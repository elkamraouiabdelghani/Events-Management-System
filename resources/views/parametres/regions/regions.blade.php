<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Régions') }}
            </h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRegionModal">
                <i class="bi bi-plus-circle me-2"></i>
                {{ __('Ajouter une région') }}
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
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

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('Region') }}</th>
                                    <th scope="col">{{ __('Nombre de Villes') }}</th>
                                    <th scope="col">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($regions as $region)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-full bg-warning bg-opacity-10 me-2" style="padding-top: 0.5rem;padding-left: 0.7rem;padding-right: 0.7rem;padding-bottom: 0.5rem;">
                                                    <i class="bi bi-globe text-warning"></i>
                                                </div>
                                                <span class="fw-medium">{{ $region->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $region->cities->count() }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editRegionModal{{ $region->id }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteRegionModal{{ $region->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Edit Region Modal --}}
                                    <div class="modal fade" id="editRegionModal{{ $region->id }}" tabindex="-1" aria-labelledby="editRegionModalLabel{{ $region->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editRegionModalLabel{{ $region->id }}">{{ __('Modifier la région') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('regions.update', $region) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name{{ $region->id }}" class="form-label">{{ __('Nom') }} <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control rounded" 
                                                                   id="name{{ $region->id }}" name="name" value="{{ $region->name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">{{ __('Mettre à jour') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Delete Region Modal -->
                                    <div class="modal fade" id="deleteRegionModal{{ $region->id }}" tabindex="-1" aria-labelledby="deleteRegionModalLabel{{ $region->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteRegionModalLabel{{ $region->id }}">{{ __('Supprimer la région') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ __('Êtes-vous sûr de vouloir supprimer la région') }} <strong>"{{ $region->name }}"</strong> ?</p>
                                                    <p class="text-muted">{{ __('Cette action est irréversible.') }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Annuler') }}</button>
                                                    <form action="{{ route('regions.destroy', $region) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">{{ __('Supprimer') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                                {{ __('Aucune région trouvée') }}
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

    <!-- Add Region Modal -->
    <div class="modal fade" id="addRegionModal" tabindex="-1" aria-labelledby="addRegionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRegionModalLabel">{{ __('Ajouter une région') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('regions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nom') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 300px;
            max-width: 400px;
            z-index: 9999;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            border-left: 4px solid;
        }

        .toast-notification.show {
            transform: translateX(0);
        }

        .toast-notification.success {
            border-left-color: #28a745;
        }

        .toast-notification.success .toast-content i {
            color: #28a745;
        }

        .toast-notification.error {
            border-left-color: #dc3545;
        }

        .toast-notification.error .toast-content i {
            color: #dc3545;
        }

        .toast-content {
            display: flex;
            align-items: center;
            flex: 1;
            font-size: 14px;
            color: #333;
        }

        .toast-close {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .toast-close:hover {
            background-color: #f0f0f0;
            color: #333;
        }

        @media (max-width: 768px) {
            .toast-notification {
                bottom: 10px;
                right: 10px;
                left: 10px;
                min-width: auto;
                max-width: none;
            }
        }
    </style>

    <script>
        function showToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('show');
                
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    closeToast(toastId);
                }, 5000);
            }
        }

        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        }

        // Show toasts on page load
        document.addEventListener('DOMContentLoaded', function() {
            const successToast = document.getElementById('successToast');
            const errorToast = document.getElementById('errorToast');
            
            if (successToast) {
                showToast('successToast');
            }
            
            if (errorToast) {
                showToast('errorToast');
            }
        });
    </script>
</x-app-layout>