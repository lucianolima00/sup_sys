<!-- Name -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="name" :value="__('Nome fantasia')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $client->name)" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<!-- Company Name -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="company_name" :value="__('Razão social')" />
    <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name', $client->company_name)" autofocus autocomplete="company_name" />
    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
</div>

<!-- CPF/CNPJ -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="cpf_cnpj" :value="__('CPF/CNPJ')" />
    <x-text-input id="cpf_cnpj" class="block mt-1 w-full" type="text" name="cpf_cnpj" :value="old('cpf_cnpj', $client->cpf_cnpj)" />
    <x-input-error :messages="$errors->get('cpf_cnpj')" class="mt-2" />
</div>

<!-- Email -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $client->email)" autofocus autocomplete="email" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- Phone -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="phone" :value="__('Telefone')" />
    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $client->phone)" autofocus autocomplete="phone" />
    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
</div>

<!-- Address Public Place -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address_public_place" :value="__('Logradouro')" />
    <x-text-input id="address_public_place" class="block mt-1 w-full" type="text" name="address_public_place" :value="old('address_public_place', $client->address_public_place)" autofocus autocomplete="address_public_place" />
    <x-input-error :messages="$errors->get('address_public_place')" class="mt-2" />
</div>

<!-- Address Number -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address_number" :value="__('Número')" />
    <x-text-input id="address_number" class="block mt-1 w-full" type="text" name="address_number" :value="old('address_number', $client->address_number)" autofocus autocomplete="address_number" />
    <x-input-error :messages="$errors->get('address_number')" class="mt-2" />
</div>

<!-- Address Complement -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address_complement" :value="__('Complemento')" />
    <x-text-input id="address_complement" class="block mt-1 w-full" type="text" name="address_complement" :value="old('address_complement', $client->address_complement)" autofocus autocomplete="address_complement" />
    <x-input-error :messages="$errors->get('address_complement')" class="mt-2" />
</div>

<!-- Address Zip Code -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address_zip_code" :value="__('CEP')" />
    <x-text-input id="address_zip_code" class="block mt-1 w-full" type="text" name="address_zip_code" :value="old('address_zip_code', $client->address_zip_code)" autofocus autocomplete="address_zip_code" />
    <x-input-error :messages="$errors->get('address_zip_code')" class="mt-2" />
</div>

<!-- Address Neighborhood -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address_neighborhood" :value="__('Bairro')" />
    <x-text-input id="address_neighborhood" class="block mt-1 w-full" type="text" name="address_neighborhood" :value="old('address_neighborhood', $client->address_neighborhood)" autofocus autocomplete="address_neighborhood" />
    <x-input-error :messages="$errors->get('address_neighborhood')" class="mt-2" />
</div>

<!-- Address City -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address_city" :value="__('Cidade')" />
    <x-text-input id="address_city" class="block mt-1 w-full" type="text" name="address_city" :value="old('address_city', $client->address_city)" autofocus autocomplete="address_city" />
    <x-input-error :messages="$errors->get('address_city')" class="mt-2" />
</div>

<!-- Address State -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address_state" :value="__('Estado')" />
    <x-text-input id="address_state" class="block mt-1 w-full" type="text" name="address_state" :value="old('address_state', $client->address_state)" autofocus autocomplete="address_state" />
    <x-input-error :messages="$errors->get('address_state')" class="mt-2" />
</div>

<div class="flex items-center justify-end mt-4">
    <x-secondary-button class="ml-4" href="{{route('clients.index')}}">
        {{ __('Voltar') }}
    </x-secondary-button>
    <x-primary-button class="ml-4">
        {{ __('Salvar') }}
    </x-primary-button>
</div>

<script>
    $(document).ready(function(){
        let cpf_cnpj = $('#cpf_cnpj');
        let phone = $('#phone');
        let cep = $('#address_zip_code');

        const cpfCnpjOptions = {
            onKeyPress: function (string, e, field, cpfCnpjOptions) {
                var masks = ['999.999.999-99Z', '99.999.999/9999-99'];
                var mask = string.replace(/[./-]/g, '').length > 11 ? masks[1] : masks[0];

                field.unmask();
                field.mask(mask, cpfCnpjOptions);

                field[0].setSelectionRange(field.val().length, field.val().length);
                field.focus();
            },
            translation:  {'Z': {pattern: /[0-9]/, optional: true}}
        };

        const phoneOptions = {
            onKeyPress: function (string, e, field, phoneOptions) {
                var masks = ['999.999.999-99Z', '99.999.999/9999-99'];
                var mask = string.replace(/[ ./-]/g, '').length > 11 ? masks[1] : masks[0];

                field.unmask();
                field.mask(mask, phoneOptions);

                field[0].setSelectionRange(field.val().length, field.val().length);
                field.focus();
            },
            translation:  {'Z': {pattern: /[0-9]/, optional: true}}
        };

        if (cpf_cnpj.val().replace(/[./-]/g, '').length === '' || cpf_cnpj.val().replace(/[./-]/g, '').length > 11) {
            cpf_cnpj.mask('99.999.999/9999-99', cpfCnpjOptions);
        } else {
            cpf_cnpj.mask('999.999.999-99', cpfCnpjOptions);
        }

        if (phone.val().replace(/[ ./-]/g, '').length === '' || phone.val().replace(/[ ./-]/g, '').length > 10) {
            phone.mask('(99) 9 9999-9999', phoneOptions);
        } else if(phone.val().replace(/[ ./-]/g, '').length > 9) {
            phone.mask('(99) 9999-9999', phoneOptions);
        } else if(phone.val().replace(/[ ./-]/g, '').length > 8) {
            phone.mask('9 9999-9999', phoneOptions);
        } else {
            phone.mask('9999-9999', phoneOptions);
        }

        cep.mask('99999-999');
    });
</script>
