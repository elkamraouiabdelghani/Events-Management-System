<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div id="successAlert" class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-r-lg shadow-sm" role="alert">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="bi bi-check-circle-fill me-3 text-green-500 text-lg"></i>
                            <span class="block sm:inline font-medium">{{ session('success') }}</span>
                        </div>
                        <button type="button" class="text-green-600 hover:text-green-800 transition-colors duration-200" onclick="closeAlert('successAlert')">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div id="errorAlert" class="bg-red-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-r-lg shadow-sm" role="alert">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="bi bi-exclamation-circle-fill me-3 text-red-500 text-lg"></i>
                            <span class="block sm:inline font-medium">{{ session('error') }}</span>
                        </div>
                        <button type="button" class="text-red-600 hover:text-red-800 transition-colors duration-200" onclick="closeAlert('errorAlert')">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            @endif
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            @if(Auth::user()->role === 'organizer')
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-organizer-form')
                </div>
            </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
        </div>
    </div>

    <script>
        // Auto-hide success and error messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s ease-out';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 500);
                }, 5000);
            }
            
            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.transition = 'opacity 0.5s ease-out';
                    errorAlert.style.opacity = '0';
                    setTimeout(() => errorAlert.remove(), 500);
                }, 5000);
            }
        });

        // Function to close alerts manually
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }
    </script>
</x-app-layout>
