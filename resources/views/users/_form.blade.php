<!-- Name -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="name" :value="__('Nome')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<!-- Email -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required autocomplete="email" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- Password -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="password" :value="__('Senha')" />

    <x-text-input id="password" class="block mt-1 w-full"
                  type="password"
                  name="password"
                  required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Password Confirmation -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="password_confirmation" :value="__('Confirme a senha')" />

    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                  type="password"
                  name="password_confirmation" required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>

<div class="flex items-center justify-end mt-4">
    <x-secondary-button class="ml-4" href="{{route('users.index')}}">
        {{ __('Voltar') }}
    </x-secondary-button>
    <x-primary-button class="ml-4">
        {{ __('Salvar') }}
    </x-primary-button>
</div>

<script>
    $(document).ready(function(){
        let cpf_cnpj = $('#cpf_cnpj');
        var options = {
            onKeyPress: function (string, e, field, options) {
                var masks = ['999.999.999-99Z', '99.999.999/9999-99'];
                console.log(string.replace(/[./-]/g, '').length);
                var mask = string.replace(/[./-]/g, '').length > 11 ? masks[1] : masks[0];

                field.unmask();
                field.mask(mask, options);

                field[0].setSelectionRange(field.val().length, field.val().length);
                field.focus();
            },
            translation:  {'Z': {pattern: /[0-9]/, optional: true}}
        };
        if (cpf_cnpj.val().replace(/[./-]/g, '').length > 11) {
            cpf_cnpj.mask('99.999.999/9999-99', options);
        } else {
            cpf_cnpj.mask('999.999.999-99', options);
        }
    });
</script>
