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
                        <label for="organizer_title" class="form-label">Nom de l'organisateur <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded @error('organizer_title') is-invalid @enderror" id="organizer_title" name="organizer_title" value="{{ old('organizer_title') }}" required>
                        @error('organizer_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            
            const regionSelect = document.getElementById('region_id');
            const citySelect = document.getElementById('city_id');
            
            if (regionSelect && citySelect) {
                regionSelect.addEventListener('change', function() {
                    const selectedOption = regionSelect.options[regionSelect.selectedIndex];
                    const cities = selectedOption.getAttribute('data-cities');
                    citySelect.innerHTML = '<option value="">Sélectionner une ville</option>';
                    if (cities) {
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
                    } else {
                        citySelect.disabled = true;
                    }
                });
            }

            const eventForm = document.getElementById('eventForm');
            const openConfirmModalBtn = document.getElementById('openConfirmModal');
            const confirmModalElement = document.getElementById('confirmModal');
            const confirmSubmitBtn = document.getElementById('confirmSubmit');
            const validationErrorModalElement = document.getElementById('validationErrorModal');
            const validationErrorList = document.getElementById('validationErrorList');

            console.log('Elements found:', {
                eventForm: !!eventForm,
                openConfirmModalBtn: !!openConfirmModalBtn,
                confirmModalElement: !!confirmModalElement,
                confirmSubmitBtn: !!confirmSubmitBtn,
                validationErrorModalElement: !!validationErrorModalElement,
                validationErrorList: !!validationErrorList
            });

            // Initialize modals
            let confirmModal, validationErrorModal;
            if (typeof bootstrap !== 'undefined') {
                confirmModal = new bootstrap.Modal(confirmModalElement);
                validationErrorModal = new bootstrap.Modal(validationErrorModalElement);
            } else {
                // Fallback modal implementations
                confirmModal = {
                    show: function() {
                        confirmModalElement.style.display = 'block';
                        confirmModalElement.classList.add('show');
                        document.body.classList.add('modal-open');
                    }
                };
                validationErrorModal = {
                    show: function() {
                        validationErrorModalElement.style.display = 'block';
                        validationErrorModalElement.classList.add('show');
                        document.body.classList.add('modal-open');
                    }
                };
            }

            if (openConfirmModalBtn) {
                openConfirmModalBtn.addEventListener('click', function(e) {
                    console.log('Button clicked');
                    e.preventDefault();
                    
                    // Validate form before showing modal
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
                    
                    @if(Auth::user()->role === 'admin')
                    requiredFields.push({ id: 'organizer_title', name: 'Nom de l\'organisateur' });
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
                    
                    if (missingFields.length > 0) {
                        // Show error message
                        validationErrorList.innerHTML = '<ul>' + missingFields.map(name => `<li>${name}</li>`).join('') + '</ul>';
                        validationErrorModal.show();
                        return;
                    }
                    
                    // Fill modal with form data
                    const title = document.getElementById('title').value;
                    const description = document.getElementById('description').value;
                    const category = document.getElementById('category_id').selectedOptions[0]?.textContent || '';
                    const region = document.getElementById('region_id').selectedOptions[0]?.textContent || '';
                    const city = document.getElementById('city_id').selectedOptions[0]?.textContent || '';
                    const place = document.getElementById('place').value;
                    const date = document.getElementById('date').value;
                    const time = document.getElementById('time').value;
                    
                    console.log('Form data:', { title, description, category, region, city, place, date, time });

                    document.getElementById('confTitle').textContent = title;
                    document.getElementById('confDescription').textContent = description;
                    document.getElementById('confCategory').textContent = category;
                    document.getElementById('confRegion').textContent = region;
                    document.getElementById('confCity').textContent = city;
                    document.getElementById('confPlace').textContent = place;
                    document.getElementById('confDate').textContent = date;
                    document.getElementById('confTime').textContent = time;
                    
                    @if(Auth::user()->role === 'admin')
                    const organizer = document.getElementById('organizer_title').value;
                    document.getElementById('confOrganizer').textContent = organizer;
                    @endif

                    // Show modal using Bootstrap
                    if (typeof bootstrap !== 'undefined') {
                        const confirmModal = new bootstrap.Modal(confirmModalElement);
                        confirmModal.show();
                    } else {
                        // Fallback: show modal manually
                        confirmModalElement.style.display = 'block';
                        confirmModalElement.classList.add('show');
                        document.body.classList.add('modal-open');
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    }
                });
            }

            if (confirmSubmitBtn) {
                confirmSubmitBtn.addEventListener('click', function() {
                    console.log('Confirm clicked');
                    if (eventForm) {
                        eventForm.submit();
                    }
                });
            }

            // Close modal when clicking outside or on close button
            // Only add manual close for fallback (when Bootstrap is not available)
            if (typeof bootstrap === 'undefined') {
                const closeButtons = document.querySelectorAll('[data-bs-dismiss="modal"], .btn-close');
                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        confirmModalElement.style.display = 'none';
                        confirmModalElement.classList.remove('show');
                        validationErrorModalElement.style.display = 'none';
                        validationErrorModalElement.classList.remove('show');
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                    });
                });
            }

            // Close modal when clicking on backdrop
            const modals = [confirmModalElement, validationErrorModalElement];
            modals.forEach(modal => {
                if (modal) {
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            if (typeof bootstrap !== 'undefined') {
                                const modalInstance = bootstrap.Modal.getInstance(modal);
                                if (modalInstance) modalInstance.hide();
                            } else {
                                modal.style.display = 'none';
                                modal.classList.remove('show');
                                document.body.classList.remove('modal-open');
                                const backdrop = document.querySelector('.modal-backdrop');
                                if (backdrop) backdrop.remove();
                            }
                        }
                    });
                }
            });

            // Map modal logic
            const closeMapModal = document.getElementsByClassName('closeMapModal');
            const openMapModalBtn = document.getElementById('openMapModal');
            const mapModalElement = document.getElementById('mapModal');
            let map, marker, selectedLatLng, selectedAddress;
            const mapAddress = document.getElementById('mapAddress');
            const selectLocationBtn = document.getElementById('selectLocationBtn');
            const placeInput = document.getElementById('place');
            let mapInitialized = false;
            // Search elements
            const mapSearchInput = document.getElementById('mapSearchInput');
            const mapSearchBtn = document.getElementById('mapSearchBtn');
            const mapSearchError = document.getElementById('mapSearchError');
            let mapModal = null;

            if (typeof bootstrap !== 'undefined' && mapModalElement) {
                mapModal = new bootstrap.Modal(mapModalElement);
                mapModalElement.addEventListener('hidden.bs.modal', function() {
                    mapModalElement.style.display = 'none';
                    mapModalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                });
            }

            if (openMapModalBtn && mapModalElement) {
                openMapModalBtn.addEventListener('click', function() {
                    if (typeof bootstrap !== 'undefined' && mapModal) {
                        mapModal.show();
                    } else {
                        mapModalElement.style.display = 'block';
                        mapModalElement.classList.add('show');
                        document.body.classList.add('modal-open');
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        document.body.appendChild(backdrop);
                    }
                    setTimeout(() => {
                        if (!mapInitialized) {
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
                                        mapAddress.textContent = selectedAddress;
                                    })
                                    .catch(() => {
                                        selectedAddress = `${e.latlng.lat}, ${e.latlng.lng}`;
                                        mapAddress.textContent = selectedAddress;
                                    });
                            });
                            mapInitialized = true;
                        } else {
                            map.invalidateSize();
                        }
                    }, 300);
                });
            }
            // Search location logic
            function searchLocation() {
                const query = mapSearchInput.value.trim();
                mapSearchError.style.display = 'none';
                if (!query) return;
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
                            mapAddress.textContent = selectedAddress;
                        } else {
                            mapSearchError.textContent = 'Lieu non trouvé.';
                            mapSearchError.style.display = 'block';
                        }
                    })
                    .catch(() => {
                        mapSearchError.textContent = 'Erreur lors de la recherche.';
                        mapSearchError.style.display = 'block';
                    });
            }
            if (mapSearchBtn) {
                mapSearchBtn.addEventListener('click', searchLocation);
            }
            if (mapSearchInput) {
                mapSearchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchLocation();
                    }
                });
            }
            if (selectLocationBtn) {
                selectLocationBtn.addEventListener('click', function() {
                    if (selectedAddress) {
                        placeInput.value = selectedAddress;
                        if (typeof bootstrap !== 'undefined') {
                            const mapModal = bootstrap.Modal.getInstance(mapModalElement);
                            if (mapModal) mapModal.hide();
                        } else {
                            mapModalElement.style.display = 'none';
                            mapModalElement.classList.remove('show');
                            document.body.classList.remove('modal-open');
                            const backdrop = document.querySelector('.modal-backdrop');
                            if (backdrop) backdrop.remove();
                        }
                    }
                });
            }

            // Ensure map modal is fully hidden when close icon or cancel button is clicked
            Array.from(closeMapModal).forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (typeof bootstrap !== 'undefined' && mapModal) {
                        mapModal.hide();
                    }
                    mapModalElement.style.display = 'none';
                    mapModalElement.classList.remove('show');
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                });
            });
        });
    </script>
</x-app-layout>

