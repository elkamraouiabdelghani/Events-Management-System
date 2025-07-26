<x-guest-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @endpush
    
    @include('userInterface.partials.navigation')

    <!-- Page Header -->
    <section class="py-4 bg-white border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('Accueil') }}" class="text-decoration-none">
                            <i class="bi bi-house me-1"></i>Accueil
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('Événements') }}" class="text-decoration-none">Événements</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $event->title }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Event Title and Category -->
    <section class="py-4 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    @if($event->category)
                        <span class="badge bg-primary mb-3">
                            <i class="bi bi-tag me-1"></i>{{ $event->category->name }}
                        </span>
                    @endif
                    <h1 class="display-5 fw-bold text-dark mb-2">{{ $event->title }}</h1>
                    <p class="lead text-muted mb-0">{{ Str::limit($event->description, 200) }}</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex align-items-center justify-content-lg-end">
                        <i class="bi bi-calendar-event text-primary me-2 fs-4"></i>
                        <span class="fs-5 text-muted">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Image and Organizer Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <!-- Event Image -->
                <div class="col-lg-8">
                    @if($event->image)
                        <img src="{{ asset('images/events/' . $event->image) }}" 
                             alt="{{ $event->title }}" 
                             class="img-fluid rounded-3 shadow-lg w-100"
                             style="height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center w-100"
                             style="height: 400px;">
                            <i class="bi bi-calendar-event text-white" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Organizer Info -->
                <div class="col-lg-4">
                    @if($event->organizer)
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4">
                                <h4 class="fw-bold text-dark mb-4">
                                    <i class="bi bi-person-circle text-primary me-2"></i>
                                    Organisateur
                                </h4>
                                
                                <div class="text-center mb-4">
                                    @if($event->organizer->logo)
                                        <img src="{{ asset('images/organizers/' . $event->organizer->logo) }}" 
                                             alt="{{ $event->organizer->name }}" 
                                             class="rounded-circle mb-3 shadow-sm"
                                             style="width: 100px; height: 100px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm"
                                             style="width: 100px; height: 100px;">
                                            <i class="bi bi-building text-primary" style="font-size: 2.5rem;"></i>
                                        </div>
                                    @endif
                                    <h5 class="fw-bold text-dark mb-1">{{ $event->organizer->name }}</h5>
                                    <p class="text-muted mb-0">Organisateur d'événements</p>
                                </div>
                                
                                <div class="mb-4">
                                    @if($event->organizer->email)
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-envelope text-primary me-3"></i>
                                            <div>
                                                <small class="text-muted d-block">Email</small>
                                                <span class="fw-semibold">{{ $event->organizer->email }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($event->organizer->phone)
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-telephone text-primary me-3"></i>
                                            <div>
                                                <small class="text-muted d-block">Téléphone</small>
                                                <span class="fw-semibold">{{ $event->organizer->phone }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-outline-primary rounded-pill" 
                                            data-bs-toggle="modal" data-bs-target="#organizerModal">
                                        <i class="bi bi-info-circle me-2"></i>Voir plus de détails
                                    </button>
                                    @if($event->organizer->email)
                                        <a href="mailto:{{ $event->organizer->email }}" class="btn btn-primary rounded-pill">
                                            <i class="bi bi-envelope me-2"></i>Contacter
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                                <div class="text-center text-muted">
                                    <i class="bi bi-person-x" style="font-size: 3rem;"></i>
                                    <p class="mt-3 mb-0">Aucun organisateur</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Event Details -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="">
                    <!-- Event Description -->
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-body p-4">
                            <h3 class="fw-bold text-dark mb-3">
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                À propos de cet événement
                            </h3>
                            <div class="text-muted lh-lg">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-body p-4">
                            <h3 class="fw-bold text-dark mb-4">
                                <i class="bi bi-calendar-check text-primary me-2"></i>
                                Détails de l'événement
                            </h3>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                            <i class="bi bi-calendar3 text-primary fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">Date et Heure</h6>
                                            <p class="text-muted mb-0">
                                                {{ \Carbon\Carbon::parse($event->date)->format('l, d F Y') }}<br>
                                                <span class="fw-semibold">{{ $event->time }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                            <i class="bi bi-geo-alt text-success fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">Lieu</h6>
                                            <p class="text-muted mb-0">
                                                {{ $event->place }}<br>
                                                @if($event->city)
                                                    <span class="fw-semibold">{{ $event->city->name }}</span>
                                                    @if($event->region)
                                                        , {{ $event->region->name }}
                                                    @endif
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($event->category)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                                            <i class="bi bi-tag text-warning fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">Catégorie</h6>
                                            <p class="text-muted mb-0">
                                                <span class="badge bg-warning bg-opacity-20 text-black">
                                                    {{ $event->category->name }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-info bg-opacity-10 rounded-3 p-3 me-3">
                                            <i class="bi bi-clock text-info fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">Statut</h6>
                                            <p class="text-black mb-0">
                                                <span class="badge bg-warning bg-opacity-20 text-black">
                                                    {{ $event->status }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                {{-- <div class="col-lg-4">
                    <!-- Action Buttons -->
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-dark mb-3">
                                <i class="bi bi-calendar-plus text-primary me-2"></i>
                                Participer
                            </h4>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-lg rounded-pill">
                                    <i class="bi bi-ticket-perforated me-2"></i>Réserver ma place
                                </button>
                                <button class="btn btn-outline-primary rounded-pill">
                                    <i class="bi bi-share me-2"></i>Partager l'événement
                                </button>
                                <button class="btn btn-outline-secondary rounded-pill">
                                    <i class="bi bi-heart me-2"></i>Ajouter aux favoris
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-dark mb-3">
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                Informations rapides
                            </h4>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-2">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <span class="text-muted">Événement confirmé</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="bi bi-shield-check text-success me-2"></i>
                                    <span class="text-muted">Paiement sécurisé</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="bi bi-arrow-clockwise text-success me-2"></i>
                                    <span class="text-muted">Remboursement possible</span>
                                </li>
                                <li class="d-flex align-items-center">
                                    <i class="bi bi-headset text-success me-2"></i>
                                    <span class="text-muted">Support 24/7</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    @include('userInterface.partials.footer-bottom')

    <!-- Organizer Modal -->
    @if($event->organizer)
    <div class="modal fade" id="organizerModal" tabindex="-1" aria-labelledby="organizerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold" id="organizerModalLabel">
                        <i class="bi bi-person-circle me-2"></i>
                        Informations sur l'organisateur
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- Organizer Header -->
                    <div class="bg-light p-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                @if($event->organizer->image)
                                    <img src="{{ asset('images/organizers/' . $event->organizer->image) }}" 
                                         alt="{{ $event->organizer->user->name }}" 
                                         class="rounded-circle shadow-sm"
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                         style="width: 100px; height: 100px;">
                                        <i class="bi bi-building text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col">
                                <h4 class="fw-bold text-dark mb-2">{{ $event->organizer->user->name }}</h4>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    Organisateur d'événements
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Organizer Details -->
                    <div class="p-4">
                        <div class="row g-4">
                            @if($event->organizer->email)
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                                        <i class="bi bi-envelope text-primary fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">Email</h6>
                                        <p class="text-muted mb-0">
                                            <a href="mailto:{{ $event->organizer->email }}" class="text-decoration-none">
                                                {{ $event->organizer->user->email }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($event->organizer->phone)
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-success bg-opacity-10 rounded-3 p-3 me-3">
                                        <i class="bi bi-telephone text-success fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">Téléphone</h6>
                                        <p class="text-muted mb-0">
                                            <a href="tel:{{ $event->organizer->phone }}" class="text-decoration-none">
                                                {{ $event->organizer->user->phone }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        @if($event->organizer->description)
                        <div class="mt-4">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                À propos
                            </h6>
                            <p class="text-muted lh-lg">
                                {{ $event->organizer->description }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

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

        .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.5);
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        @media (max-width: 768px) {
            .display-4 {
                font-size: 2rem;
            }
            
            .event-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</x-guest-layout>
