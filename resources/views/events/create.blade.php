<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
                {{ __('Créer un événement') }}
            </h2>
            <a href="{{ route('events') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> {{ __('Retour à la liste') }}
            </a>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form id="eventForm" method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-4">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control rounded @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control rounded @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                    <select class="form-select rounded @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="region_id" class="form-label">Région <span class="text-danger">*</span></label>
                    <select class="form-select rounded @error('region_id') is-invalid @enderror" id="region_id" name="region_id" required>
                        <option value="">Sélectionner une région</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" data-cities='@json($region->cities)'>{{ $region->name }}</option>
                        @endforeach
                    </select>
                    @error('region_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="city_id" class="form-label">Ville <span class="text-danger">*</span></label>
                    <select class="form-select rounded @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required disabled>
                        <option value="">Sélectionner une ville</option>
                    </select>
                    @error('city_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="place" class="form-label">Lieu 
                        <span class="text-danger">*</span>
                        <span class="text-muted">
                            <i class="bi bi-info-circle-fill"></i>
                            Vous pouvez sélectionner un lieu sur la carte ou saisir le lieu manuellement.
                        </span>
                    </label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control rounded-start @error('place') is-invalid @enderror" id="place" name="place" value="{{ old('place') }}" required placeholder="Sélectionner ou saisir le lieu">
                        <button type="button" class="btn btn-outline-secondary" id="openMapModal" title="Choisir sur la carte">
                            <i class="bi bi-geo-alt-fill"></i>
                        </button>
                    </div>
                    @error('place')<div class="invalid-feedback">{{ $message }}</div>@enderror

                    <!-- Map Modal -->
                    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mapModalLabel">Sélectionner l'emplacement sur la carte</h5>
                                    <button type="button" class="btn-close closeMapModal" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="height: 500px;">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="mapSearchInput" placeholder="Rechercher un lieu (ex: Casablanca, Maroc)">
                                        <button class="btn btn-outline-primary" id="mapSearchBtn" type="button"><i class="bi bi-search"></i></button>
                                    </div>
                                    <div id="mapSearchError" class="text-danger small mb-2" style="display:none;"></div>
                                    <div id="eventMap" style="height: 400px; width: 100%; border-radius: 8px;"></div>
                                    <div class="mt-2 text-muted small" id="mapAddress"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary closeMapModal" data-bs-dismiss="modal">Annuler</button>
                                    <button type="button" class="btn btn-primary" id="selectLocationBtn">Sélectionner cet emplacement</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control rounded @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" required>
                        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="time" class="form-label">Heure <span class="text-danger">*</span></label>
                        <input type="time" class="form-control rounded @error('time') is-invalid @enderror" id="time" name="time" value="{{ old('time') }}" required>
                        @error('time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="event_image" class="form-label">Image de l'événement</label>
                    <input type="file" class="form-control rounded @error('event_image') is-invalid @enderror" id="event_image" name="event_image" accept="image/*" required>
                    @error('event_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @if(Auth::user()->role === 'admin')
                    <div class="mb-3">
                        <label class="form-label">Organisateur <span class="text-danger">*</span></label>
                        
                        <!-- Toggle Buttons -->
                        <div class="btn-group w-100 mb-3" role="group" aria-label="Organizer type selection">
                            <input type="radio" class="btn-check" name="organizer_type" id="new_organizer" value="new" checked>
                            <label class="btn btn-outline-primary" for="new_organizer">
                                <i class="bi bi-plus-circle me-2"></i>Nouvel Organisateur
                            </label>
                            
                            <input type="radio" class="btn-check" name="organizer_type" id="existing_organizer" value="existing">
                            <label class="btn btn-outline-primary" for="existing_organizer">
                                <i class="bi bi-list-ul me-2"></i>Organisateur Existant
                            </label>
                        </div>

                        <!-- New Organizer Input -->
                        <div id="new_organizer_section">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-plus"></i>
                                </span>
                                <input type="text" class="form-control rounded-end @error('organizer_title') is-invalid @enderror" 
                                       id="organizer_title" name="organizer_title" 
                                       value="{{ old('organizer_title') }}" 
                                       placeholder="Nom du nouvel organisateur">
                                @error('organizer_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Créez un nouvel organisateur pour cet événement
                            </div>
                        </div>

                        <!-- Existing Organizer Dropdown -->
                        <div id="existing_organizer_section" style="display: none;">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-check"></i>
                                </span>
                                <select class="form-select rounded-end @error('existing_organizer_id') is-invalid @enderror" 
                                        id="existing_organizer_id" name="existing_organizer_id">
                                    <option value="">Sélectionner un organisateur existant</option>
                                    @foreach($organizers as $organizer)
                                        <option value="{{ $organizer->id }}" {{ old('existing_organizer_id') == $organizer->id ? 'selected' : '' }}>
                                            {{ $organizer->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('existing_organizer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Choisissez parmi les organisateurs existants
                            </div>

                        </div>
                    </div>
                @elseif(Auth::user()->role === 'organizer' && Auth::user()->organizer)
                    <input type="hidden" name="organizer_id" value="{{ Auth::user()->organizer->id }}">
                @endif
                <div class="d-flex justify-content-end">
                    <button type="button" id="openConfirmModal" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle me-2"></i>Créer l'événement
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmer la création de l'événement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <i class="bi bi-calendar2-event display-4 text-primary mb-2"></i>
                        <h4 class="fw-bold mb-2" id="confTitle"></h4>
                        {{-- <p class="mb-1" id="confDescription"></p> --}}
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <div class="bg-light rounded p-2">
                                <span class="fw-semibold">Catégorie:</span> <span id="confCategory"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-2">
                                <span class="fw-semibold">Région:</span> <span id="confRegion"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-2">
                                <span class="fw-semibold">Ville:</span> <span id="confCity"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-2">
                                <span class="fw-semibold">Lieu:</span> <span id="confPlace"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-2">
                                <span class="fw-semibold">Date:</span> <span id="confDate"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded p-2">
                                <span class="fw-semibold">Heure:</span> <span id="confTime"></span>
                            </div>
                        </div>
                        @if(Auth::user()->role === 'admin')
                        <div class="col-12">
                            <div class="bg-light rounded p-2">
                                <span class="fw-semibold">Organisateur:</span> <span id="confOrganizer"></span>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-12">
                        <div class="bg-light rounded p-2">
                            <span class="fw-semibold">Description:</span> <span id="confDescription"></span>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        Merci de vérifier les informations de l'événement avant de confirmer la création.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" id="confirmSubmit" class="btn btn-success">Confirmer et créer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Validation Error Modal -->
    <div class="modal fade" id="validationErrorModal" tabindex="-1" aria-labelledby="validationErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="validationErrorModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Erreur de validation
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-exclamation-circle display-4 text-danger mb-2"></i>
                        <h4 class="fw-bold text-danger mb-2">Champs obligatoires manquants</h4>
                        <p class="text-muted">Veuillez remplir tous les champs obligatoires avant de continuer.</p>
                    </div>
                    <div class="alert alert-danger">
                        <strong>Champs à remplir :</strong>
                        <ul class="mb-0 mt-2" id="validationErrorList"></ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bi bi-check-circle me-2"></i>Compris
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        /* Modern toggle button styles */
        .btn-group .btn-check:checked + .btn {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .btn-group .btn-check:not(:checked) + .btn {
            background-color: transparent;
            border-color: #dee2e6;
            color: #6c757d;
            transition: all 0.2s ease-in-out;
        }
        
        .btn-group .btn-check:not(:checked) + .btn:hover {
            background-color: #f8f9fa;
            border-color: #0d6efd;
            color: #0d6efd;
        }
        
        /* Smooth transitions for organizer sections */
        #new_organizer_section,
        #existing_organizer_section {
            transition: all 0.3s ease-in-out;
        }
        
        /* Input group styling */
        .input-group-text {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
        
        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all required elements
            const elements = {
                eventForm: document.getElementById('eventForm'),
                openConfirmModalBtn: document.getElementById('openConfirmModal'),
                confirmModalElement: document.getElementById('confirmModal'),
                confirmSubmitBtn: document.getElementById('confirmSubmit'),
                validationErrorModalElement: document.getElementById('validationErrorModal'),
                validationErrorList: document.getElementById('validationErrorList'),
                openMapModalBtn: document.getElementById('openMapModal'),
                mapModalElement: document.getElementById('mapModal'),
                mapAddress: document.getElementById('mapAddress'),
                selectLocationBtn: document.getElementById('selectLocationBtn'),
                placeInput: document.getElementById('place'),
                mapSearchInput: document.getElementById('mapSearchInput'),
                mapSearchBtn: document.getElementById('mapSearchBtn'),
                mapSearchError: document.getElementById('mapSearchError'),
                closeMapModal: document.getElementsByClassName('closeMapModal')
            };

            // Check if Bootstrap is available
            const hasBootstrap = typeof bootstrap !== 'undefined';

            // Initialize modals
            let confirmModal, validationErrorModal, mapModal;
            if (hasBootstrap) {
                if (elements.confirmModalElement) {
                    confirmModal = new bootstrap.Modal(elements.confirmModalElement);
                }
                if (elements.validationErrorModalElement) {
                    validationErrorModal = new bootstrap.Modal(elements.validationErrorModalElement);
                }
                if (elements.mapModalElement) {
                    mapModal = new bootstrap.Modal(elements.mapModalElement);
                }
            }

            // Modal utility functions
            const modalUtils = {
                show: function(modalElement, modalInstance) {
                    if (hasBootstrap && modalInstance) {
                        modalInstance.show();
                    } else {
                        modalElement.style.display = 'block';
                        modalElement.classList.add('show');
                        document.body.classList.add('modal-open');
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    }
                },
                hide: function(modalElement, modalInstance) {
                    if (hasBootstrap && modalInstance) {
                        modalInstance.hide();
                    } else {
                        modalElement.style.display = 'none';
                        modalElement.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                    }
                }
            };

            // Form validation function
            function validateForm() {
                const requiredFields = [
                    { id: 'title', name: 'Titre' },
                    { id: 'description', name: 'Description' },
                    { id: 'category_id', name: 'Catégorie' },
                    { id: 'region_id', name: 'Région' },
                    { id: 'city_id', name: 'Ville' },
                    { id: 'place', name: 'Lieu' },
                    { id: 'date', name: 'Date' },
                    { id: 'time', name: 'Heure' }
                ];

                // Add organizer validation for admin users
                @if(Auth::user()->role === 'admin')
                const organizerTypeRadio = document.querySelector('input[name="organizer_type"]:checked');
                if (organizerTypeRadio) {
                    const organizerType = organizerTypeRadio.value;
                    if (organizerType === 'new') {
                        requiredFields.push({ id: 'organizer_title', name: 'Nom de l\'organisateur' });
                    } else {
                        requiredFields.push({ id: 'existing_organizer_id', name: 'Organisateur existant' });
                    }
                }
                @endif

                const missingFields = [];
                
                requiredFields.forEach(field => {
                    const element = document.getElementById(field.id);
                    if (!element || !element.value.trim()) {
                        missingFields.push(field.name);
                        if (element) {
                            element.classList.add('is-invalid');
                        }
                    } else {
                        if (element) {
                            element.classList.remove('is-invalid');
                        }
                    }
                });

                return missingFields;
            }

            // Fill confirmation modal with form data
            function fillConfirmationModal() {
                const formData = {
                    title: document.getElementById('title')?.value || '',
                    description: document.getElementById('description')?.value || '',
                    category: document.getElementById('category_id')?.selectedOptions[0]?.textContent || '',
                    region: document.getElementById('region_id')?.selectedOptions[0]?.textContent || '',
                    city: document.getElementById('city_id')?.selectedOptions[0]?.textContent || '',
                    place: document.getElementById('place')?.value || '',
                    date: document.getElementById('date')?.value || '',
                    time: document.getElementById('time')?.value || ''
                };

                // Update modal content
                const modalElements = {
                    'confTitle': formData.title,
                    'confDescription': formData.description,
                    'confCategory': formData.category,
                    'confRegion': formData.region,
                    'confCity': formData.city,
                    'confPlace': formData.place,
                    'confDate': formData.date,
                    'confTime': formData.time
                };

                Object.keys(modalElements).forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.textContent = modalElements[id];
                    }
                });

                // Handle organizer info for admin users
                @if(Auth::user()->role === 'admin')
                const organizerTypeRadio = document.querySelector('input[name="organizer_type"]:checked');
                if (organizerTypeRadio) {
                    const organizerType = organizerTypeRadio.value;
                    let organizerInfo = '';
                    
                    if (organizerType === 'new') {
                        organizerInfo = document.getElementById('organizer_title')?.value || '';
                    } else {
                        const existingOrganizerSelect = document.getElementById('existing_organizer_id');
                        const selectedOption = existingOrganizerSelect?.options[existingOrganizerSelect.selectedIndex];
                        organizerInfo = selectedOption ? selectedOption.textContent : '';
                    }
                    
                    const confOrganizerElement = document.getElementById('confOrganizer');
                    if (confOrganizerElement) {
                        confOrganizerElement.textContent = organizerInfo;
                    }
                }
                @endif
            }

            // Confirmation modal event handlers
            if (elements.openConfirmModalBtn) {
                elements.openConfirmModalBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const missingFields = validateForm();
                    
                    if (missingFields.length > 0) {
                        // Show validation error modal
                        if (elements.validationErrorList) {
                            elements.validationErrorList.innerHTML = missingFields.map(name => `<li>${name}</li>`).join('');
                        }
                        modalUtils.show(elements.validationErrorModalElement, validationErrorModal);
                        return;
                    }
                    
                    fillConfirmationModal();
                    modalUtils.show(elements.confirmModalElement, confirmModal);
                });
            }

            if (elements.confirmSubmitBtn) {
                elements.confirmSubmitBtn.addEventListener('click', function() {
                    if (elements.eventForm) {
                        elements.eventForm.submit();
                    }
                });
            }

            // Map functionality
            let map, marker, selectedLatLng, selectedAddress;
            let mapInitialized = false;

            function initializeMap() {
                if (!mapInitialized && elements.mapModalElement) {
                    try {
                        map = L.map('eventMap').setView([31.7917, -7.0926], 6); // Morocco center
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(map);

                        map.on('click', function(e) {
                            if (marker) map.removeLayer(marker);
                            marker = L.marker(e.latlng).addTo(map);
                            selectedLatLng = e.latlng;
                            
                            // Reverse geocode
                            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
                                .then(res => res.json())
                                .then(data => {
                                    selectedAddress = data.display_name || `${e.latlng.lat}, ${e.latlng.lng}`;
                                    if (elements.mapAddress) {
                                        elements.mapAddress.textContent = selectedAddress;
                                    }
                                })
                                .catch(() => {
                                    selectedAddress = `${e.latlng.lat}, ${e.latlng.lng}`;
                                    if (elements.mapAddress) {
                                        elements.mapAddress.textContent = selectedAddress;
                                    }
                                });
                        });
                        
                        mapInitialized = true;
                    } catch (error) {
                        console.error('Error initializing map:', error);
                    }
                } else if (mapInitialized && map) {
                    map.invalidateSize();
                }
            }

            function searchLocation() {
                const query = elements.mapSearchInput?.value.trim();
                if (!query || !elements.mapSearchError) return;

                elements.mapSearchError.style.display = 'none';
                
                fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(query)}&countrycodes=MA&limit=1`)
                    .then(res => res.json())
                    .then(results => {
                        if (results && results.length > 0) {
                            const loc = results[0];
                            const latlng = [parseFloat(loc.lat), parseFloat(loc.lon)];
                            map.setView(latlng, 14);
                            if (marker) map.removeLayer(marker);
                            marker = L.marker(latlng).addTo(map);
                            selectedLatLng = { lat: latlng[0], lng: latlng[1] };
                            selectedAddress = loc.display_name;
                            if (elements.mapAddress) {
                                elements.mapAddress.textContent = selectedAddress;
                            }
                        } else {
                            elements.mapSearchError.textContent = 'Lieu non trouvé.';
                            elements.mapSearchError.style.display = 'block';
                        }
                    })
                    .catch(() => {
                        elements.mapSearchError.textContent = 'Erreur lors de la recherche.';
                        elements.mapSearchError.style.display = 'block';
                    });
            }

            // Map modal event handlers
            if (elements.openMapModalBtn) {
                elements.openMapModalBtn.addEventListener('click', function() {
                    modalUtils.show(elements.mapModalElement, mapModal);
                    setTimeout(initializeMap, 300);
                });
            }

            if (elements.mapSearchBtn) {
                elements.mapSearchBtn.addEventListener('click', searchLocation);
            }

            if (elements.mapSearchInput) {
                elements.mapSearchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchLocation();
                    }
                });
            }

            if (elements.selectLocationBtn) {
                elements.selectLocationBtn.addEventListener('click', function() {
                    if (selectedAddress && elements.placeInput) {
                        elements.placeInput.value = selectedAddress;
                        modalUtils.hide(elements.mapModalElement, mapModal);
                    }
                });
            }

            // Close map modal handlers
            Array.from(elements.closeMapModal).forEach(function(btn) {
                btn.addEventListener('click', function() {
                    modalUtils.hide(elements.mapModalElement, mapModal);
                });
            });

            // Close modals when clicking on backdrop
            [elements.confirmModalElement, elements.validationErrorModalElement, elements.mapModalElement].forEach(modal => {
                if (modal) {
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            if (modal === elements.confirmModalElement) {
                                modalUtils.hide(modal, confirmModal);
                            } else if (modal === elements.validationErrorModalElement) {
                                modalUtils.hide(modal, validationErrorModal);
                            } else if (modal === elements.mapModalElement) {
                                modalUtils.hide(modal, mapModal);
                            }
                        }
                    });
                }
            });

            // Close buttons for all modals
            const closeButtons = document.querySelectorAll('[data-bs-dismiss="modal"], .btn-close');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modal = this.closest('.modal');
                    if (modal) {
                        if (modal === elements.confirmModalElement) {
                            modalUtils.hide(modal, confirmModal);
                        } else if (modal === elements.validationErrorModalElement) {
                            modalUtils.hide(modal, validationErrorModal);
                        } else if (modal === elements.mapModalElement) {
                            modalUtils.hide(modal, mapModal);
                        }
                    }
                });
            });

            // Region/City dynamic loading (if not already handled by inline script)
            const regionSelect = document.getElementById('region_id');
            const citySelect = document.getElementById('city_id');
            
            if (regionSelect && citySelect) {
                regionSelect.addEventListener('change', function() {
                    const selectedOption = regionSelect.options[regionSelect.selectedIndex];
                    const cities = selectedOption.getAttribute('data-cities');
                    
                    citySelect.innerHTML = '<option value="">Sélectionner une ville</option>';
                    
                    if (cities) {
                        try {
                            const citiesArr = JSON.parse(cities);
                            if (citiesArr.length > 0) {
                                citySelect.disabled = false;
                                citiesArr.forEach(city => {
                                    const option = document.createElement('option');
                                    option.value = city.id;
                                    option.textContent = city.name;
                                    citySelect.appendChild(option);
                                });
                            } else {
                                citySelect.disabled = true;
                            }
                        } catch (error) {
                            console.error('Error parsing cities data:', error);
                            citySelect.disabled = true;
                        }
                    } else {
                        citySelect.disabled = true;
                    }
                });
            }

            // Organizer type toggle (for admin users)
            @if(Auth::user()->role === 'admin')
            const newOrganizerRadio = document.getElementById('new_organizer');
            const existingOrganizerRadio = document.getElementById('existing_organizer');
            const newOrganizerSection = document.getElementById('new_organizer_section');
            const existingOrganizerSection = document.getElementById('existing_organizer_section');

            function toggleOrganizerSection() {
                if (newOrganizerRadio && existingOrganizerRadio && newOrganizerSection && existingOrganizerSection) {
                    if (newOrganizerRadio.checked) {
                        newOrganizerSection.style.display = '';
                        existingOrganizerSection.style.display = 'none';
                    } else {
                        newOrganizerSection.style.display = 'none';
                        existingOrganizerSection.style.display = '';
                    }
                }
            }

            if (newOrganizerRadio) {
                newOrganizerRadio.addEventListener('change', toggleOrganizerSection);
            }
            if (existingOrganizerRadio) {
                existingOrganizerRadio.addEventListener('change', toggleOrganizerSection);
            }
            @endif
        });
    </script>
</x-app-layout>

