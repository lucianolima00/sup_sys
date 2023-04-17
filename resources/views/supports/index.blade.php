@php

use App\Widgets\Formatter;
use App\Models\Client;
use App\Models\Collaborator;
use App\Constants\CollaboratorTypes;
use App\Constants\SupportStatus;

@endphp

@extends('layouts.interface')

@section('title', 'Chamados')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb d-flex align-items-center justify-content-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Listagem') }}
                </h2>
            </div>
            <div>
                <a class="btn btn-success" href="{{ route('supports.create') }}" title="Adicionar um chamado"> <i
                        class="fas fa-plus-circle"></i>
                    {{ __('Adicionar') }}
                </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
    @endif

    {!! grid_view([
        'dataProvider' => $dataProvider,
        'countColumn' => false,
        'useFilters' => true,
        'searchButtonStyle' => 'background-color:  #0d6efd',
        'resetButtonStyle' => 'background-color: #ffc107; color: white',
        'columnFields' => [
            [
                'class' => Lucianolima00\GridView\Columns\ActionColumn::class,
                'actionTypes' => [
                    'edit' => function ($data) {
                        return route('supports.edit', ['support' => $data]);
                    },
                    [
                        'class' => Lucianolima00\GridView\Actions\Delete::class, // Required
                        'url' => function ($data) {
                            return route('supports.destroy', ['support' => $data]);
                        },
                        'htmlAttributes' => [
                            'data-method' => 'post',
                            'onclick' => 'return window.confirm("Tem certeza que deseja excluir?");'
                        ]
                    ]
                ]
            ],
            [
                'label' => 'Código',
                'attribute' => 'id',
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
                'class' => 'text-nowrap',
            ],
            [
                'label' => 'Data de abertura',
                'attribute' => 'opening_date',
                'value' => function ($row) {
                    return Formatter::asDate($row->opening_date);
                },
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
                'class' => 'text-nowrap',
            ],
            [
                'label' => 'Técnico 1',
                'attribute' => 'primary_collaborator_id',
                'value' => function ($row) {
                    if ($collaborator = Collaborator::find($row->primary_collaborator_id)) {
                        return $collaborator->name;
                    }
                    return $row->primary_collaborator_id;
                },
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem',
                ],
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\DropdownFilter::class,
                    'data' => [Arr::get(Arr::get($_GET, 'filters'), 'primary_collaborator_id') => Collaborator::find(Arr::get(Arr::get($_GET, 'filters'), 'primary_collaborator_id'))?->name]
                ],
                'class' => 'text-nowrap',
            ],
            [
                'label' => 'Técnico 2',
                'attribute' => 'secondary_collaborator_id',
                'value' => function ($row) {
                    if ($collaborator = Collaborator::find($row->secondary_collaborator_id)) {
                        return $collaborator->name;
                    }
                    return $row->secondary_collaborator_id;
                },
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\DropdownFilter::class,
                    'data' => [Arr::get(Arr::get($_GET, 'filters'), 'secondary_collaborator_id') => Collaborator::find(Arr::get(Arr::get($_GET, 'filters'), 'secondary_collaborator_id'))?->name]
                ],
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
                'class' => 'text-nowrap',
            ],
            [
                'label' => 'Data de agendamento',
                'attribute' => 'start_datetime',
                'value' => function ($row) {
                    return Formatter::asDatetime($row->start_datetime);
                },
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
                'class' => 'text-nowrap',
            ],
            [
                'label' => 'Cliente',
                'attribute' => 'client_id',
                'value' => function ($row) {
                    if ($client = Client::find($row->client_id)) {
                        return $client->name;
                    }
                    return $row->client_id;
                },
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\DropdownFilter::class,
                    'data' => [Arr::get(Arr::get($_GET, 'filters'), 'client_id') => Client::find(Arr::get(Arr::get($_GET, 'filters'), 'client_id'))?->name]
                ],
                'class' => 'text-nowrap',
            ],
            [
                'label' => 'Localidade',
                'attribute' => 'address',
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
                'class' => 'text-nowrap',
            ],
            [
                'label' => 'Solicitante',
                'attribute' => 'requester_id',
                'value' => function ($row) {
                    if ($collaborator = Collaborator::find($row->requester_id)) {
                        return $collaborator->name;
                    }
                    return $row->requester_id;
                },
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\DropdownFilter::class,
                    'data' => [Arr::get(Arr::get($_GET, 'filters'), 'requester_id') => Collaborator::find(Arr::get(Arr::get($_GET, 'filters'), 'requester_id'))?->name]
                ],
                'class' => 'text-nowrap',
            ],
            [
                'label' => 'Descrição',
                'attribute' => 'description',
                'value' => function ($row) {
                    return substr($row->description, 0, 100);
                },
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem; min-width: 20rem'
                ]
            ],
            [
                'label' => 'Status',
                'attribute' => 'status',
                'value' => function ($row) {
                    return Arr::get(SupportStatus::list(), $row->status);
                },
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\DropdownFilter::class,
                    'data' => SupportStatus::list(),
                ],
                'htmlAttributes' => [
                    'style' => 'padding-right: 6rem'
                ],
                'class' => 'text-nowrap',
            ],
            [
                'label' => 'Andamento/Solução',
                'attribute' => 'solution',
                'value' => function ($row) {
                    return substr($row->solution, 0, 100);
                },
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem; min-width: 20rem'
                ]
            ],
        ]
    ]) !!}

    <!-- Script -->
    <script type="text/javascript">
        flatpickr("#opening_date_filter", {
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            disableMobile: "true",
            altInput: "true",
        });
        flatpickr("#start_datetime_filter", {
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
            $("#primary_collaborator_id_filter").select2({
                language: "pt-BR",
                allowClear: true,
                placeholder: 'Selecione...',
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
                            used_id: $("#secondary_collaborator_id_filter").val(),
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

            $("#secondary_collaborator_id_filter").select2({
                language: "pt-BR",
                allowClear: true,
                placeholder: 'Selecione...',
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
                            used_id: $("#primary_collaborator_id_filter").val(),
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

            $("#client_id_filter").select2({
                language: "pt-BR",
                allowClear: true,
                placeholder: 'Selecione...',
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

            $("#requester_id_filter").select2({
                language: "pt-BR",
                allowClear: true,
                placeholder: 'Selecione...',
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
@stop
