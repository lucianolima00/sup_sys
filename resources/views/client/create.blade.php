<x-app-layout>
    <x-guest-layout>
        <form method="POST" action="{{ route('client.store') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nome')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Company Name -->
            <div class="mt-4">
                <x-input-label for="company_name" :value="__('Razão Social')" />
                <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('E-mail')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Company Name -->
            <div class="mt-4">
                <x-input-label for="company_name" :value="__('Razão Social')" />
                <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Cadastrar') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</x-app-layout>
