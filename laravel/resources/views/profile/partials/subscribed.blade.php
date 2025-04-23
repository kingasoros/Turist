<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Subscribe') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("If you don't want to miss out on the new tours, subscribe to the ones you're interested in!") }}
        </p>
    </header>
    
    <form method="post" action="" class="mt-6 space-y-6">
        @csrf
    
        <div>
            <x-input-label :value="__('Select Cities')" />

            {{-- Közvetlen adatlekérés Blade-ben --}}
            @php
                $cities = DB::table('cities')->orderBy('city_name')->get();
            @endphp
    
            @foreach($cities as $city)
                <div class="flex items-center mt-2">
                    <input
                        type="checkbox"
                        id="city_{{ $city->city_id }}"
                        name="selected_cities[]"
                        value="{{ $city->city_id }}"
                        class="text-indigo-600 focus:ring-indigo-500 border-gray-300"
                    >
                    <label for="city_{{ $city->city_id }}" class="ml-2 text-sm dark:text-gray-400">
                        {{ $city->city_name }}, {{ $city->country_name }} ({{ $city->zip_code }})
                    </label>
                </div>
            @endforeach
    
            <x-input-error :messages="$errors->get('selected_cities')" class="mt-2" />
        </div>
    
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Subscribe') }}</x-primary-button>
        </div>
    </form>
</section>
