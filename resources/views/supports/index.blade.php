@php use App\Widgets\Formatter;use App\Constants\SupportStatus; @endphp

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
        'searchButtonStyle' => 'background-color: #0d6efd',
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
            ],
            [
                'label' => 'Data de abertura',
                'attribute' => 'opening_date',
            ],
            [
                'label' => 'Técnico 1',
                'attribute' => 'primary_collaborator_id',
            ],
            [
                'label' => 'Técnico 2',
                'attribute' => 'secondary_collaborator_id',
            ],
            [
                'label' => 'Data de agendamento',
                'attribute' => 'start_datetime',
            ],
            [
                'label' => 'Cliente',
                'attribute' => 'client_id',
            ],
            [
                'label' => 'Localidade',
                'attribute' => 'address',
            ],
            [
                'label' => 'Descrição',
                'attribute' => 'description',
            ],
            [
                'label' => 'Status',
                'attribute' => 'status',
                'value' => function ($row) {
                    return Arr::get(SupportStatus::list(), $row->status);
                },
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\DropdownFilter::class,
                    'data' => SupportStatus::list()
                ]
            ],
            [
                'label' => 'Andamento/Solução',
                'attribute' => 'solution',
            ],
        ]
    ]) !!}
@stop
