<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informations de l\'organisateur') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Mettez à jour les informations spécifiques à votre profil d\'organisateur.') }}
        </p>
    </header>

    <form method="post" action="{{ route('organizers.update', $user->organizer) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="title" :value="__('Titre')" />
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $user->organizer->title ?? '')" autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Téléphone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->organizer->phone_numbre ?? '')" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('description', $user->organizer->description ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Image')" />
            <input type="file" id="image" name="image" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" accept="image/*" />
            @if($user->organizer && $user->organizer->image)
                <div class="mt-2">
                    <img src="{{ asset('/images/organizers/' . $user->organizer->image) }}" alt="Image actuelle" class="h-20 w-20 object-cover rounded-lg border border-gray-300">
                </div>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'organizer-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section> 