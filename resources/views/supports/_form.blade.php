@php use App\Models\Support ;use App\Models\Collaborator;use App\Constants\SupportStatus;use App\Constants\CollaboratorTypes@endphp

    <!-- Name -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="opening_date" :value="__('Data de abertura')"/>
    <x-text-input id="opening_date" class="block mt-1 w-full" type="date-local" name="opening_date"
                  :value="old('opening_date', $support->opening_date)" required autofocus autocomplete="opening_date"/>
    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
</div>

<!-- Status -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="status" :value="__('Status')"/>
    <x-select-input id="status" placeholder="Selecione um status" class="block mt-1 w-full" type="text" name="status"
                    :value="old('status', $support->status)" :data="SupportStatus::list()"/>
    <x-input-error :messages="$errors->get('status')" class="mt-2"/>
</div>

<!-- Primary Collaborator ID -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="primary_collaborator_id" :value="__('Técnico 1')"/>
    <x-select-input id="primary_collaborator_id" :select2 placeholder="Selecione um técnico" class="block mt-1 w-full"
                    type="text" name="primary_collaborator_id"
                    :value="old('primary_collaborator_id', $support->primary_collaborator_id)"/>
    <x-input-error :messages="$errors->get('primary_collaborator_id')" class="mt-2"/>
</div>

<!-- Secondary Collaborator ID -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="secondary_collaborator_id" :value="__('Técnico 2')"/>
    <x-select-input id="secondary_collaborator_id" :select2 placeholder="Selecione um técnico" class="block mt-1 w-full"
                    type="text" name="secondary_collaborator_id"
                    :value="old('secondary_collaborator_id', $support->secondary_collaborator_id)"/>
    <x-input-error :messages="$errors->get('secondary_collaborator_id')" class="mt-2"/>
</div>

<!-- Start Datetime -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="start_datetime" :value="__('Data de agendamento')"/>
    <x-text-input id="start_datetime" type="datetime-local" class="block mt-1 w-full" name="birth_day"
                  :value="old('start_datetime', $support->start_datetime)"/>
    <x-input-error :messages="$errors->get('start_datetime')" class="mt-2"/>
</div>

<!-- Client ID -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="client_id" :value="__('Cliente')"/>
    <x-select-input id="client_id" :select2 placeholder="Selecione um cliente" class="block mt-1 w-full" type="text"
                    name="client_id" :value="old('client_id', $support->client_id)"/>
    <x-input-error :messages="$errors->get('client_id')" class="mt-2"/>
</div>

<!-- Address -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address" :value="__('Localidade')"/>
    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                  :value="old('address', $support->address)" autofocus autocomplete="address"/>
    <x-input-error :messages="$errors->get('address')" class="mt-2"/>
</div>

<!-- Requester ID -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="requester_id" :value="__('Solicitante')"/>
    <x-select-input id="requester_id" :select2 placeholder="Selecione o solicitante" class="block mt-1 w-full"
                    type="text" name="requester_id" :value="old('requester_id', $support->requester_id)"/>
    <x-input-error :messages="$errors->get('requester_id')" class="mt-2"/>
</div>

<!-- Address Zip Code -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address_zip_code" :value="__('CEP')"/>
    <x-text-input id="address_zip_code" class="block mt-1 w-full" type="text" name="address_zip_code"
                  :value="old('address_zip_code', $support->address_zip_code)" autofocus
                  autocomplete="address_zip_code"/>
    <x-input-error :messages="$errors->get('address_zip_code')" class="mt-2"/>
</div>

<!-- Address Neighborhood -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address_neighborhood" :value="__('Bairro')"/>
    <x-text-input id="address_neighborhood" class="block mt-1 w-full" type="text" name="address_neighborhood"
                  :value="old('address_neighborhood', $support->address_neighborhood)" autofocus
                  autocomplete="address_neighborhood"/>
    <x-input-error :messages="$errors->get('address_neighborhood')" class="mt-2"/>
</div>

<!-- Address State -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="address_state" :value="__('Estado')"/>
    <x-text-input id="address_state" class="block mt-1 w-full" type="text" name="address_state"
                  :value="old('address_state', $support->address_state)" autofocus autocomplete="address_state"/>
    <x-input-error :messages="$errors->get('address_state')" class="mt-2"/>
</div>

<div class="flex items-center justify-end mt-4">
    <x-secondary-button class="ml-4" href="{{route('supports.index')}}">
        {{ __('Voltar') }}
    </x-secondary-button>
    <x-primary-button class="ml-4">
        {{ __('Salvar') }}
    </x-primary-button>
</div>
<!-- Script -->
<script type="text/javascript">
    flatpickr("#opening_date", {
        dateFormat: 'd/m/Y',
        defaultDate: new Date(),
        disableMobile: "true",
    });
    flatpickr("#start_datetime", {
        dateFormat: 'd/m/Y H:i',
        enableTime: true,
        disableMobile: "true",
        time_24hr: true,
    });

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function () {
        $("#primary_collaborator_id").select2({
            allowClear: true,
            ajax: {
                url: "{{route('supports.collaborators')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term,
                        type: {{ CollaboratorTypes::TECHNIQUE }},
                        used_id: $("#secondary_collaborator_id").val(),
                    };
                },
                processResults: function (data, params) {
                    console.log(data);
                    console.log(params);
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $("#secondary_collaborator_id").select2({
            allowClear: true,
            ajax: {
                url: "{{route('supports.collaborators')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term,
                        type: {{ CollaboratorTypes::TECHNIQUE }},
                        used_id: $("#primary_collaborator_id").val(),
                    };
                },
                processResults: function (data, params) {
                    console.log(data);
                    console.log(params);
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $("#client_id").select2({
            allowClear: true,
            ajax: {
                url: "{{route('supports.clients')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term
                    };
                },
                processResults: function (data, params) {
                    console.log(data);
                    console.log(params);
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $("#requester_id").select2({
            allowClear: true,
            ajax: {
                url: "{{route('supports.collaborators')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term,
                        type: {{ CollaboratorTypes::REQUESTER }},
                        used_id: null,
                    };
                },
                processResults: function (data, params) {
                    console.log(data);
                    console.log(params);
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });
</script>
