<section class="py-5 bg-light">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold text-dark mb-3">
                {{-- <i class="bi bi-calendar-event me-2 text-primary"></i> --}}
                Derniers Événements
            </h2>
            <p class="text-muted fs-5">Découvrez les événements les plus récents</p>
        </div>

        @if($events && $events->count() > 0)
            <!-- Carousel Container -->
            <div id="eventsCarousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Carousel Indicators -->
                {{-- <div class="carousel-indicators">
                    @for($i = 0; $i < ceil($events->count() / 3); $i++)
                        <button type="button" data-bs-target="#eventsCarousel" data-bs-slide-to="{{ $i }}" 
                                class="{{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}" 
                                aria-label="Slide {{ $i + 1 }}"></button>
                    @endfor
                </div> --}}

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    @for($i = 0; $i < ceil($events->count() / 3); $i++)
                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                @for($j = $i * 3; $j < min(($i + 1) * 3, $events->count()); $j++)
                                    @php $event = $events[$j]; @endphp
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden hover-lift">
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
                                                
                                                <!-- Status Badge -->
                                                <div class="position-absolute top-0 end-0 m-3">
                                                    @if($event->status === 'published')
                                                        <span class="badge bg-success">Publié</span>
                                                    @elseif($event->status === 'draft')
                                                        <span class="badge bg-warning">Brouillon</span>
                                                    @elseif($event->status === 'passed')
                                                        <span class="badge bg-secondary">Terminé</span>
                                                    @elseif($event->status === 'canceled')
                                                        <span class="badge bg-danger">Annulé</span>
                                                    @endif
                                                </div>

                                                <!-- Category Badge -->
                                                @if($event->category)
                                                    <div class="position-absolute top-0 start-0 m-3">
                                                        <span class="badge bg-primary">{{ $event->category->name }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Card Body -->
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title fw-bold text-dark mb-2">{{ $event->title }}</h5>
                                                
                                                <p class="card-text text-muted flex-grow-1">
                                                    {{ Str::limit($event->description, 100) }}
                                                </p>

                                                <!-- Event Details -->
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex align-items-center mb-2 me-2">
                                                            <i class="bi bi-calendar3 text-primary me-2"></i>
                                                            <small class="text-muted">
                                                                {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                                                            </small>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="bi bi-clock text-primary me-2"></i>
                                                            <small class="text-muted">{{ $event->time }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="bi bi-geo-alt text-primary me-2"></i>
                                                        <small class="text-muted event-place-cell">{{ $event->place }}</small>
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
                                                        <small class="text-muted">{{ $event->organizer->title }}</small>
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
                                @endfor
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Carousel Controls -->
                @if($events->count() > 3)
                    <button class="carousel-control-prev" type="button" data-bs-target="#eventsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#eventsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                @endif
            </div>

            <!-- View All Events Button -->
            <div class="text-center mt-5">
                <a href="{{ route('Événements') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                    <i class="bi bi-calendar-week me-2"></i>Voir Tous les Événements
                </a>
            </div>
        @else
            <!-- No Events Message -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-muted mb-3">Aucun événement disponible</h4>
                <p class="text-muted">Revenez bientôt pour découvrir de nouveaux événements !</p>
            </div>
        @endif
    </div>

    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 40px;
            height: 40px;
        }

        .carousel-indicators {
            bottom: -50px;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #dee2e6;
            border: none;
            margin: 0 5px;
        }

        .carousel-indicators button.active {
            background-color: #0d6efd;
        }

        .event-place-cell {
            max-width: 100%;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 768px) {
            .carousel-control-prev,
            .carousel-control-next {
                display: none;
            }
        }
    </style>
</section> 