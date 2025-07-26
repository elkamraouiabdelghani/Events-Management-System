@php
    $appConfig = config('application');
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Paramètres de l\'application') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto">
            <form action="{{ route('applications.update', 1) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- App Name Section -->
                <div class="bg-white shadow rounded-lg p-6 mb-4 flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary/10">
                            <i class="bi bi-type-bold text-primary text-2xl"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 font-bold mb-1">Nom de l'application</label>
                        <input type="text" name="name" value="{{ old('name', $appConfig['name']) }}" class="form-input w-full rounded border-gray-300 focus:ring-primary focus:border-primary" required>
                        <p class="text-xs text-gray-500 mt-1">Le nom affiché dans l'application et les emails.</p>
                    </div>
                </div>

                <!-- Slogan Section -->
                <div class="bg-white shadow rounded-lg p-6 mb-4 flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-info/10">
                            <i class="bi bi-chat-quote text-info text-2xl"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 font-bold mb-1">Slogan</label>
                        <input type="text" name="slogan" value="{{ old('slogan', $appConfig['slogan']) }}" class="form-input w-full rounded border-gray-300 focus:ring-info focus:border-info">
                        <p class="text-xs text-gray-500 mt-1">Phrase d'accroche ou slogan de l'application.</p>
                    </div>
                </div>

                <!-- Logo Section -->
                <div class="bg-white shadow rounded-lg p-6 mb-4 flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-success/10">
                            <i class="bi bi-image text-success text-2xl"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 font-bold mb-1">Logo</label>
                        @if($appConfig['logo'])
                            <div class="mb-2">
                                <img src="{{ asset($appConfig['logo']) }}" alt="Logo" class="h-9 rounded shadow inline-block">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="form-input w-full rounded border-gray-300">
                        <p class="text-xs text-gray-500 mt-1">Image du logo de l'application (PNG, JPG, SVG...)</p>
                    </div>
                </div>

                <!-- Favicon Section -->
                <div class="bg-white shadow rounded-lg p-6 mb-4 flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-warning/10">
                            <i class="bi bi-star-fill text-warning text-2xl"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 font-bold mb-1">Favicon</label>
                        @if($appConfig['favicon'])
                            <div class="mb-2">
                                <img src="{{ asset($appConfig['favicon']) }}" alt="Favicon" class="h-9 rounded shadow inline-block">
                            </div>
                        @endif
                        <input type="file" name="favicon" accept="image/*,.ico" class="form-input w-full rounded border-gray-300">
                        <p class="text-xs text-gray-500 mt-1">Icône affichée dans l'onglet du navigateur (PNG, ICO...)</p>
                    </div>
                </div>

                {{-- Slider Image Section --}}
                <div class="bg-white shadow rounded-lg p-6 mb-4 flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-danger/10">
                            <i class="bi bi-image text-danger text-2xl"></i>
                        </span>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 font-bold mb-1">Image de la page d'accueil [2:1]</label>
                        @if($appConfig['slider-image'])
                            <div class="mb-2">
                                <img src="{{ asset($appConfig['slider-image']) }}" alt="Slider Image" class="h-9 rounded shadow inline-block">
                            </div>
                        @endif
                        <input type="file" name="slider-image" accept="image/*" class="form-input w-full rounded border-gray-300">
                        <p class="text-xs text-gray-500 mt-1">Image affichée sur la page d'accueil (PNG, JPG, SVG...)</p>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-primary text-white px-8 p-2 rounded hover:bg-primary-dark font-semibold shadow">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>

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

    <style>
        .toast-notification {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            min-width: 300px;
            max-width: 400px;
            z-index: 9999;
            border-left: 4px solid;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s, transform 0.3s;
        }
        .toast-notification.show {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }
        .toast-notification.success { border-left-color: #28a745; }
        .toast-notification.success .toast-content i { color: #28a745; }
        .toast-notification.error { border-left-color: #dc3545; }
        .toast-notification.error .toast-content i { color: #dc3545; }
        .toast-content { display: flex; align-items: center; flex: 1; font-size: 15px; color: #333; }
        .toast-close { background: none; border: none; color: #666; cursor: pointer; padding: 4px; border-radius: 4px; transition: background-color 0.2s; }
        .toast-close:hover { background-color: #f0f0f0; color: #333; }
        @media (max-width: 768px) {
            .toast-notification { bottom: 10px; right: 10px; left: 10px; min-width: auto; max-width: none; }
        }
    </style>
    <script>
        function closeToast(id) {
            var toast = document.getElementById(id);
            if (toast) toast.style.opacity = 0;
        }
        window.addEventListener('DOMContentLoaded', function() {
            var successToast = document.getElementById('successToast');
            var errorToast = document.getElementById('errorToast');
            if (successToast) {
                setTimeout(function() { successToast.classList.remove('show'); }, 5000);
                setTimeout(function() { successToast.style.opacity = 0; }, 5200);
                successToast.classList.add('show');
            }
            if (errorToast) {
                setTimeout(function() { errorToast.classList.remove('show'); }, 5000);
                setTimeout(function() { errorToast.style.opacity = 0; }, 5200);
                errorToast.classList.add('show');
            }
        });
    </script>
</x-app-layout>
