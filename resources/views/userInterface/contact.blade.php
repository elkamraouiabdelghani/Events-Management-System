<x-guest-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @endpush
    
    @include('userInterface.partials.navigation')

    <!-- Page Header -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">
                        <i class="bi bi-person-plus me-3"></i>
                        Devenez Organisateur
                    </h1>
                    <p class="lead mb-0">Rejoignez notre plateforme et commencez à organiser des événements exceptionnels</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex align-items-center justify-content-lg-end">
                        <i class="bi bi-star-fill me-2 fs-4"></i>
                        <span class="fs-5">Rejoignez notre communauté</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="sticky-top" style="top: 2rem;">
                        <h2 class="fw-bold mb-3 text-primary">Pourquoi devenir organisateur ?</h2>
                        <p class="mb-4 text-muted">
                            Rejoignez notre plateforme et bénéficiez d'outils puissants pour organiser et promouvoir vos événements.
                        </p>
                        
                        <!-- Benefits -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-start p-3 bg-light rounded-3">
                                    <div class="bg-success text-white rounded-circle p-2 me-3 mt-1">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">Plateforme complète</h6>
                                        <p class="mb-0 text-muted small">Gestion complète de vos événements</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start p-3 bg-light rounded-3">
                                    <div class="bg-success text-white rounded-circle p-2 me-3 mt-1">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">Promotion automatique</h6>
                                        <p class="mb-0 text-muted small">Vos événements visibles par tous</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start p-3 bg-light rounded-3">
                                    <div class="bg-success text-white rounded-circle p-2 me-3 mt-1">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">Support dédié</h6>
                                        <p class="mb-0 text-muted small">Assistance personnalisée</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start p-3 bg-light rounded-3">
                                    <div class="bg-success text-white rounded-circle p-2 me-3 mt-1">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold">Statistiques avancées</h6>
                                        <p class="mb-0 text-muted small">Suivi de performance détaillé</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="bg-light p-4 rounded-3">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-info-circle me-2 text-primary"></i>
                                Besoin d'aide ?
                            </h6>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Email:</strong></p>
                                <p class="mb-0 text-muted">contact@votresite.com</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Téléphone:</strong></p>
                                <p class="mb-0 text-muted">+212 6 12 34 56 78</p>
                            </div>
                            <div>
                                <p class="mb-1"><strong>Réponse sous 24h</strong></p>
                                <p class="mb-0 text-muted">Nous vous répondrons rapidement</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-8">
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4 text-center">
                                <i class="bi bi-clipboard-data me-2 text-primary"></i>
                                Demande d'inscription - Organisateur
                            </h4>
                            
                            <form method="POST" action="#">
                                @csrf
                                
                                <!-- Personal Information -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="fw-bold mb-3 text-primary">
                                            <i class="bi bi-person me-2"></i>
                                            Informations personnelles
                                        </h5>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label fw-semibold">
                                            Nom complet <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" 
                                               placeholder="Votre nom complet" required>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label fw-semibold">
                                            Adresse e-mail <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" 
                                               placeholder="votre@email.com" required>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label fw-semibold">
                                            Téléphone <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel" class="form-control rounded-3 @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone') }}" 
                                               placeholder="+212 6 12 34 56 78" required>
                                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="website" class="form-label fw-semibold">
                                            Site web (optionnel)
                                        </label>
                                        <input type="url" class="form-control rounded-3 @error('website') is-invalid @enderror" 
                                               id="website" name="website" value="{{ old('website') }}" 
                                               placeholder="https://votresite.com">
                                        @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <!-- Organization Information -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="fw-bold mb-3 text-primary">
                                            <i class="bi bi-building me-2"></i>
                                            Informations de l'organisation
                                        </h5>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="organization_name" class="form-label fw-semibold">
                                            Nom de l'organisation <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control rounded-3 @error('organization_name') is-invalid @enderror" 
                                               id="organization_name" name="organization_name" value="{{ old('organization_name') }}" 
                                               placeholder="Nom de votre organisation ou entreprise" required>
                                        @error('organization_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="organization_description" class="form-label fw-semibold">
                                            Description de l'organisation <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control rounded-3 @error('organization_description') is-invalid @enderror" 
                                                  id="organization_description" name="organization_description" rows="3" 
                                                  placeholder="Décrivez votre organisation, ses activités et son expérience dans l'organisation d'événements..." required>{{ old('organization_description') }}</textarea>
                                        @error('organization_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <!-- Location Information -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="fw-bold mb-3 text-primary">
                                            <i class="bi bi-geo-alt me-2"></i>
                                            Localisation
                                        </h5>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="region_id" class="form-label fw-semibold">
                                            Région <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select rounded-3 @error('region_id') is-invalid @enderror" 
                                                id="region_id" name="region_id" required>
                                            <option value="">Sélectionner une région</option>
                                            @foreach($regions ?? [] as $region)
                                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                                    {{ $region->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('region_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="city_id" class="form-label fw-semibold">
                                            Ville <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select rounded-3 @error('city_id') is-invalid @enderror" 
                                                id="city_id" name="city_id" required disabled>
                                            <option value="">Sélectionner une ville</option>
                                        </select>
                                        @error('city_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <!-- Event Categories -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="fw-bold mb-3 text-primary">
                                            <i class="bi bi-tags me-2"></i>
                                            Types d'événements
                                        </h5>
                                        <p class="text-muted mb-3">Sélectionnez les catégories d'événements que vous souhaitez organiser :</p>
                                    </div>
                                    <div class="col-12">
                                        <div class="row g-3">
                                            @foreach($categories ?? [] as $category)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" 
                                                               name="categories[]" value="{{ $category->id }}" 
                                                               id="category_{{ $category->id }}"
                                                               {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('categories')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <!-- Experience & Motivation -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="fw-bold mb-3 text-primary">
                                            <i class="bi bi-lightbulb me-2"></i>
                                            Expérience et motivation
                                        </h5>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="experience" class="form-label fw-semibold">
                                            Expérience en organisation d'événements <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control rounded-3 @error('experience') is-invalid @enderror" 
                                                  id="experience" name="experience" rows="3" 
                                                  placeholder="Décrivez votre expérience dans l'organisation d'événements, le nombre d'événements organisés, etc..." required>{{ old('experience') }}</textarea>
                                        @error('experience')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="motivation" class="form-label fw-semibold">
                                            Pourquoi souhaitez-vous rejoindre notre plateforme ? <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control rounded-3 @error('motivation') is-invalid @enderror" 
                                                  id="motivation" name="motivation" rows="3" 
                                                  placeholder="Expliquez vos motivations et ce que vous attendez de notre plateforme..." required>{{ old('motivation') }}</textarea>
                                        @error('motivation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="fw-bold mb-3 text-primary">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Informations supplémentaires
                                        </h5>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="additional_info" class="form-label fw-semibold">
                                            Informations complémentaires
                                        </label>
                                        <textarea class="form-control rounded-3 @error('additional_info') is-invalid @enderror" 
                                                  id="additional_info" name="additional_info" rows="3" 
                                                  placeholder="Toute information supplémentaire que vous souhaitez partager...">{{ old('additional_info') }}</textarea>
                                        @error('additional_info')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                        <i class="bi bi-send me-2"></i>Soumettre ma demande
                                    </button>
                                </div>
                                
                                <p class="text-muted text-center mt-3 small">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Vos informations sont protégées et ne seront utilisées que pour traiter votre demande.
                                </p>
                            </form>
                        </div>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success mt-3 border-0 rounded-3">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger mt-3 border-0 rounded-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('userInterface.partials.footer-bottom')

    <script>
        // Region/City dynamic loading
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>

    <style>
        .bg-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%) !important;
        }
        .card {
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background: linear-gradient(90deg, #0d6efd 60%, #0dcaf0 100%);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #0dcaf0 0%, #0d6efd 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        .rounded-circle {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .sticky-top {
            z-index: 1020;
        }
    </style>
</x-guest-layout>