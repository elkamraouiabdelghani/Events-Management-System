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
                        <i class="bi bi-calendar-event me-3"></i>
                        Tous les Événements
                    </h1>
                    <p class="lead mb-0">Découvrez et participez aux meilleurs événements de votre région</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex align-items-center justify-content-lg-end">
                        <i class="bi bi-funnel me-2 fs-4"></i>
                        <span class="fs-5">{{ $events->total() }} événements trouvés</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Bar -->
    <section class="py-4 bg-light border-bottom">
        <div class="container">
            <form method="GET" action="{{ route('Événements') }}" class="filter-form">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="bi bi-tag me-1"></i>Catégorie
                        </label>
                        <select name="category" class="form-select border-0 shadow-sm">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="bi bi-geo-alt me-1"></i>Région
                        </label>
                        <select name="region" class="form-select border-0 shadow-sm">
                            <option value="">Toutes les régions</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="bi bi-building me-1"></i>Ville
                        </label>
                        <select name="city" class="form-select border-0 shadow-sm">
                            <option value="">Toutes les villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="bi bi-calendar3 me-1"></i>Date
                        </label>
                        <input type="date" name="date" value="{{ request('date') }}" 
                               class="form-control border-0 shadow-sm">
                    </div>
                    
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="bi bi-clock me-1"></i>Heure
                        </label>
                        <input type="time" name="time" value="{{ request('time') }}" 
                               class="form-control border-0 shadow-sm">
                    </div>
                    
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="bi bi-search me-1"></i>Rechercher
                        </label>
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Rechercher..." 
                                   class="form-control border-0 shadow-sm">
                            <button type="submit" class="btn btn-primary border-0 shadow-sm">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Clear Filters -->
                @if(request()->hasAny(['category', 'region', 'city', 'date', 'time', 'search']))
                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('Événements') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-x-circle me-1"></i>Effacer les filtres
                            </a>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </section>

    <!-- Events Grid -->
    <section class="py-5">
        <div class="container">
            @if($events->count() > 0)
                <div class="row g-4">
                    @foreach($events as $event)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 border-0 shadow-sm rounded-3 event-card">
                                <!-- Event Image -->
                                <div class="position-relative">
                                    @if($event->image)
                                        <img src="{{ asset('images/events/' . $event->image) }}" 
                                             class="card-img-top" alt="{{ $event->title }}"
                                             style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-primary d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="bi bi-calendar-event text-white" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Category Badge -->
                                    @if($event->category)
                                        <div class="position-absolute top-0 start-0 m-3">
                                            <span class="badge bg-primary">{{ $event->category->name }}</span>
                                        </div>
                                    @endif

                                    <!-- Date Badge -->
                                    <div class="position-absolute bottom-0 start-0 m-3">
                                        <div class="bg-white rounded-3 px-3 py-2 shadow-sm">
                                            <div class="text-center">
                                                <div class="fw-bold text-primary">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</div>
                                                <div class="small text-muted">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title fw-bold text-dark mb-2">{{ $event->title }}</h5>
                                    
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ Str::limit($event->description, 120) }}
                                    </p>

                                    <!-- Event Details -->
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-clock text-primary me-2"></i>
                                            <small class="text-muted">{{ $event->time }}</small>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-geo-alt text-primary me-2"></i>
                                            <small class="text-muted">{{ $event->place }}</small>
                                        </div>
                                        @if($event->city)
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-building text-primary me-2"></i>
                                                <small class="text-muted">{{ $event->city->name }}</small>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Organizer Info -->
                                    @if($event->organizer)
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-person-circle text-primary me-2"></i>
                                            <small class="text-muted">{{ $event->organizer->name }}</small>
                                        </div>
                                    @endif

                                    <!-- Action Button -->
                                    <div class="mt-auto">
                                        <a href="{{ route('événement', $event) }}" class="btn btn-outline-primary w-100 rounded-pill">
                                            <i class="bi bi-eye me-2"></i>Voir Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $events->appends(request()->query())->links() }}
                </div>
            @else
                <!-- No Events Message -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-muted mb-3">Aucun événement trouvé</h4>
                    <p class="text-muted mb-4">
                        Aucun événement ne correspond à vos critères de recherche.
                    </p>
                    <a href="{{ route('Événements') }}" class="btn btn-primary rounded-pill">
                        <i class="bi bi-arrow-clockwise me-2"></i>Voir Tous les Événements
                    </a>
                </div>
            @endif
        </div>
    </section>

    @include('userInterface.partials.footer-bottom')

    <style>
        .event-card {
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
            border-color: #e9ecef;
        }

        .filter-form .form-control,
        .filter-form .form-select {
            background-color: white;
            transition: all 0.3s ease;
        }

        .filter-form .form-control:focus,
        .filter-form .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        /* Custom Pagination Styling */
        .pagination .page-link {
            border: none;
            color: #6c757d;
            padding: 0.75rem 1rem;
            margin: 0 0.25rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
            color: #495057;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: transparent;
        }

        @media (max-width: 768px) {
            .filter-form .row {
                margin-bottom: 1rem;
            }
            
            .event-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</x-guest-layout>
