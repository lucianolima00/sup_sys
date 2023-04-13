<!-- Name -->
<div>
    <x-input-label for="name" :value="__('Nome')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $collaborator->name)" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<!-- Company Name -->
<div class="mt-4">
    <x-input-label for="cpf_cnpj" :value="__('CPF/CNPJ')" />
    <x-text-input id="cpf_cnpj" class="block mt-1 w-full" type="text" name="cpf_cnpj" :value="old('cpf_cnpj', $collaborator->cpf_cnpj)" />
    <x-input-error :messages="$errors->get('cpf_cnpj')" class="mt-2" />
</div>

<div class="flex items-center justify-end mt-4">
    <x-secondary-button class="ml-4" href="{{route('collaborators.index')}}">
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
