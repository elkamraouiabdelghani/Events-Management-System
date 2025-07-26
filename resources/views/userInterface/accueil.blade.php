<x-guest-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    @endpush
    @include('userInterface.partials.navigation')
    @include('userInterface.partials.slider', [
        'categories' => $categories,
        'regions' => $regions,
        'cities' => $cities,
    ])
    @include('userInterface.partials.events-carousel', ['events' => $events])
    @include('userInterface.partials.our-services')
    @include('userInterface.partials.footer-bottom')
</x-guest-layout>