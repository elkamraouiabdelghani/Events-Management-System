<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
                {{ __('Ajouter un organisateur') }}
            </h2>
            <a href="{{ route('organizers') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> {{ __('Retour à la liste') }}
            </a>
        </div>
    </x-slot>

    @if(session('error'))
        <div class="alert alert-danger custom-alert mb-4" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            {{ __(session('error')) }}
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('organizers.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- Section 1: Organizer Account Info -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pb-0 pt-4">
                        <h4 class="mb-0 fw-bold d-flex align-items-center section-title">
                            <i class="bi bi-person-circle me-2"></i>
                            Informations du compte organisateur
                        </h4>
                    </div>
                    <div class="card-body pt-3">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de l'organisateur <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control rounded @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe par défaut <span class="text-danger">*</span></label>
                            <input type="password" class="form-control rounded @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Section 2: Organizer Details -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pb-0 pt-4">
                        <h4 class="mb-0 fw-bold d-flex align-items-center section-title">
                            <i class="bi bi-person-gear me-2"></i>
                            Détails de l'organisateur
                        </h4>
                    </div>
                    <div class="card-body pt-3">
                        <div class="mb-4">
                            <div class="btn-group w-100" role="group" aria-label="Choix du mode">
                                <input type="radio" class="btn-check" name="organizer_mode" id="organizerModeNew" value="new" autocomplete="off" checked>
                                <label class="btn btn-outline-primary" for="organizerModeNew"><i class="bi bi-plus-circle me-1"></i> Nouvel organisateur</label>
                                <input type="radio" class="btn-check" name="organizer_mode" id="organizerModeExisting" value="existing" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="organizerModeExisting"><i class="bi bi-list-ul me-1"></i> Sélectionner un existant</label>
                            </div>
                        </div>
                        <div id="organizerDetailsNew">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre (ex: nom de la société) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone_numbre" class="form-label">Téléphone <span class="text-muted">(facultatif)</span></label>
                                <input type="text" class="form-control rounded @error('phone_numbre') is-invalid @enderror" id="phone_numbre" name="phone_numbre" value="{{ old('phone_numbre') }}">
                                @error('phone_numbre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-muted">(facultatif)</span></label>
                                <textarea class="form-control rounded @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Image <span class="text-muted">(facultatif)</span></label>
                                <input type="file" class="form-control rounded @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div id="organizerDetailsExisting" style="display:none;">
                            <div class="mb-3">
                                <label for="existing_organizer_id" class="form-label">Sélectionner un organisateur existant <span class="text-danger">*</span></label>
                                <select class="form-select" id="existing_organizer_id" name="existing_organizer_id">
                                    <option value="">-- Choisir un organisateur --</option>
                                    @foreach($organizers as $org)
                                        <option value="{{ $org->id }}">{{ $org->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const modeNew = document.getElementById('organizerModeNew');
                                const modeExisting = document.getElementById('organizerModeExisting');
                                const detailsNew = document.getElementById('organizerDetailsNew');
                                const detailsExisting = document.getElementById('organizerDetailsExisting');
                                function toggleDetails() {
                                    if (modeNew.checked) {
                                        detailsNew.style.display = '';
                                        detailsExisting.style.display = 'none';
                                    } else {
                                        detailsNew.style.display = 'none';
                                        detailsExisting.style.display = '';
                                    }
                                }
                                modeNew.addEventListener('change', toggleDetails);
                                modeExisting.addEventListener('change', toggleDetails);
                            });
                        </script>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-plus-circle me-2"></i> Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
    <style>
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
        }
        .invalid-feedback {
            font-size: 0.95em;
        }
        .section-title {
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #222;
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        .card-header {
            background: #f8fafc;
            padding-top: 1.5rem !important;
        }
        .btn-primary {
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        .custom-alert {
            background: #fff5f5;
            color: #b02a37;
            border-left: 4px solid #ff6b6b;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(220,53,69,0.10);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            font-size: 15px;
        }
        .custom-alert i {
            color: #ff6b6b;
            font-size: 1.3em;
        }
    </style>
</x-app-layout>
