<section class="relative w-full" style="min-height: 500px;">
    <!-- Slider Background Image -->
    <div class="absolute inset-0 w-full h-full opacity-75" style="background: url('{{ config('application.slider-image') }}') center/cover no-repeat;"></div>
    {{-- <div class="absolute inset-0 w-full h-full bg-black bg-opacity-60"></div> --}}
    <div class="relative z-10 flex flex-col items-center justify-center text-center py-20" style="padding-top: 100px;">
        <h1 class="text-5xl md:text-6xl font-extrabold text-white my-4" style="text-shadow: 0 4px 24px rgba(0,0,0,0.7);font-weight: 600;font-size: 3rem;">
            {{ config('application.name', 'Events') }}
        </h1>
        <p class="text-xl md:text-2xl text-white font-medium mb-8 drop-shadow" style="text-shadow: 0 2px 8px rgba(0,0,0,0.5);font-weight: 400;font-size: 1.5rem;">
            {{ config('application.slogan', 'Gérez vos événements avec facilité') }}
        </p>

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('Événements') }}" class="filter-bar mx-auto flex flex-wrap gap-4 items-end justify-center bg-white bg-opacity-95 rounded shadow-lg px-6 py-4 mt-4" style="backdrop-filter: blur(2px);width: 95%;max-width: 1200px;">
            @csrf
            <div class="flex-1 min-w-[140px] filter-bar-input">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Catégorie</label>
                <select name="category" class="form-select rounded w-full">
                    <option value="">Toutes</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[140px] filter-bar-input">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Région</label>
                <select name="region" class="form-select rounded w-full">
                    <option value="">Toutes</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[140px] filter-bar-input">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Ville</label>
                <select name="city" class="form-select rounded w-full">
                    <option value="">Toutes</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[140px] filter-bar-input">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Date</label>
                <input type="date" name="date" class="form-control rounded w-full">
            </div>
            <div class="flex-1 min-w-[140px] filter-bar-input">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Heure</label>
                <input type="time" name="time" class="form-control rounded w-full">
            </div>
            <div class="flex-1 items-end filter-bar-input">
                <label for="search" class="text-sm font-semibold mb-1 text-gray-700 block">Rechercher</label>
                <button type="submit" class="btn btn-primary px-6 py-2 rounded-lg font-semibold shadow bg-black text-white hover:bg-gray-800 transition">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
    <style>
        @media (max-width: 768px) {
            .filter-bar {
                flex-direction: column !important;
                align-items: center !important;
                gap: 0 !important;
                margin-bottom: 1rem;
            }
            .filter-bar-input {
                width: 90% !important;
                margin-bottom: 1rem;
            }
            .filter-bar-input:last-child {
                margin-bottom: 0;
            }
        }
    </style>
</section>