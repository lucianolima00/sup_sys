@php use App\Widgets\Formatter;use App\Constants\SupportStatus;use App\Constants\CollaboratorTypes@endphp
    <!-- ID -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="id" :value="__('Código')"/>
    <x-text-input id="id" disabled="true" class="block mt-1 w-full" type="text" name="id"
                  :value="Formatter::asID(old('id', $support->id))" autocomplete="id"/>
    <x-input-error :messages="$errors->get('id')" class="mt-2"/>
</div>

<!-- Status -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="status" :value="__('Status')"/>
    <x-select-input id="status" class="block mt-1 w-full" type="text" name="status"
                    :value="old('status', $support->status)" :data="SupportStatus::list()"/>
    <x-input-error :messages="$errors->get('status')" class="mt-2"/>
</div>

<!-- Opening Date -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="opening_date" :value="__('Data de abertura')"/>
    <x-text-input id="opening_date" class="block mt-1 w-full" type="date-local" name="opening_date"
                  :value="old('opening_date', $support->opening_date)" required autocomplete="opening_date"/>
    <x-input-error :messages="$errors->get('opening_date')" class="mt-2"/>
</div>

<!-- Start Datetime -->
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="start_datetime" :value="__('Data de agendamento')"/>
    <x-text-input id="start_datetime" type="datetime-local" class="block mt-1 w-full" name="start_datetime"
                  :value="old('start_datetime', $support->start_datetime)"/>
    <x-input-error :messages="$errors->get('start_datetime')" class="mt-2"/>
</div>

<!-- Primary Collaborator ID -->
@php
    $data = old('primary_collaborator_id', $support->primary_collaborator_id) ? [old('primary_collaborator_id', $support->primary_collaborator_id) => $support->primary_collaborator->name] : null
@endphp
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="primary_collaborator_id" :value="__('Técnico 1')"/>
    <x-select-input id="primary_collaborator_id" placeholder="Selecione um técnico" class="block mt-1 w-full"
                    type="text" name="primary_collaborator_id"
                    :value="old('primary_collaborator_id', $support->primary_collaborator_id)"
                    :data="$data"/>
    <x-input-error :messages="$errors->get('primary_collaborator_id')" class="mt-2"/>
</div>

<!-- Secondary Collaborator ID -->
@php
    $data = old('secondary_collaborator_id', $support->secondary_collaborator_id) ? [old('secondary_collaborator_id', $support->secondary_collaborator_id) => $support->secondary_collaborator->name] : null
@endphp
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="secondary_collaborator_id" :value="__('Técnico 2')"/>
    <x-select-input id="secondary_collaborator_id" placeholder="Selecione um técnico" class="block mt-1 w-full"
                    type="text" name="secondary_collaborator_id"
                    :value="old('secondary_collaborator_id', $support->secondary_collaborator_id)"
                    :data="$data"/>
    <x-input-error :messages="$errors->get('secondary_collaborator_id')" class="mt-2"/>
</div>

<!-- Client ID -->
@php
    $data = old('client_id', $support->client_id) ? [old('client_id', $support->client_id) => $support->client->name] : null
@endphp
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="client_id" :value="__('Cliente')"/>
    <x-select-input id="client_id" placeholder="Selecione um cliente" class="block mt-1 w-full" type="text"
                    name="client_id" :value="old('client_id', $support->client_id)"
                    :data="$data"/>
    <x-input-error :messages="$errors->get('client_id')" class="mt-2"/>
</div>

<!-- Requester ID -->
@php
    $data = old('requester_id', $support->requester_id) ? [old('requester_id', $support->requester_id) => $support->requester->name] : null
@endphp
<div class="col-12 col-md-6 col-lg-6 col-xl-6 mt-4">
    <x-input-label for="requester_id" :value="__('Solicitante')"/>
    <x-select-input id="requester_id" placeholder="Selecione o solicitante" class="block mt-1 w-full"
                    type="text" name="requester_id" :value="old('requester_id', $support->requester_id)"
                    :data="$data"/>
    <x-input-error :messages="$errors->get('requester_id')" class="mt-2"/>
</div>

<!-- Address -->
<div class="col-12 col-md-12 col-lg-12 col-xl-12 mt-4">
    <x-input-label for="address" :value="__('Localidade')"/>
    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                  :value="old('address', $support->address)" autocomplete="address"/>
    <x-input-error :messages="$errors->get('address')" class="mt-2"/>
</div>

<!-- Description -->
<div class="col-12 col-md-12 col-lg-12 col-xl-12 mt-4">
    <x-input-label for="description" :value="__('Descrição')"/>
    <x-textarea-input id="description" class="block mt-1 w-full" cols="4" rows="5" name="description"
                      :value="old('description', $support->description)"
                      autocomplete="description"/>
    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
</div>

<!-- Solution -->
<div class="col-12 col-md-12 col-lg-12 col-xl-12 mt-4">
    <x-input-label for="solution" :value="__('Andamento/Solução')"/>
    <x-textarea-input id="solution" class="block mt-1 w-full" cols="4" rows="5" name="solution"
                      :value="old('solution', $support->solution)"
                      autocomplete="solution"/>
    <x-input-error :messages="$errors->get('solution')" class="mt-2"/>
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
        dateFormat: 'Y-m-d',
        altFormat: 'd/m/Y',
        defaultDate: new Date(),
        disableMobile: "true",
        altInput: "true",
    });
    flatpickr("#start_datetime", {
        dateFormat: 'Y-m-d H:i',
        altFormat: 'd/m/Y H:i',
        enableTime: true,
        disableMobile: "true",
        time_24hr: true,
        altInput: "true",
    });

    // CSRF Token
    const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function () {
        $("#primary_collaborator_id").select2({
            language: "pt-BR",
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
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $("#secondary_collaborator_id").select2({
            language: "pt-BR",
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
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $("#client_id").select2({
            language: "pt-BR",
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
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $("#requester_id").select2({
            language: "pt-BR",
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
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });
</script>
