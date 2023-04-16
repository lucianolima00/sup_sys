@php use App\Widgets\Formatter;use Illuminate\Support\Arr;use App\Constants\CollaboratorTypes; @endphp

@extends('layouts.interface')

@section('title', 'Colaboradores')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb d-flex align-items-center justify-content-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Listagem') }}
                </h2>
            </div>
            <div>
                <a class="btn btn-success" href="{{ route('collaborators.create') }}" title="Adicionar um colaborador">
                    <i
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
                        return route('collaborators.edit', ['collaborator' => $data]);
                    },
                    [
                        'class' => Lucianolima00\GridView\Actions\Delete::class, // Required
                        'url' => function ($data) {
                            return route('collaborators.destroy', ['collaborator' => $data]);
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
            ],
            [
                'label' => 'Nome',
                'attribute' => 'name',
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
            ],
            [
                'label' => 'Tipo',
                'attribute' => 'type',
                'value' => function ($row) {
                    return Arr::get(CollaboratorTypes::list(), $row->type);
                },
                'htmlAttributes' => [
                    'style' => 'padding-right: 6rem'
                ],
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\DropdownFilter::class,
                    'data' => CollaboratorTypes::list(),
                ]
            ],
            [
                'label' => 'Email',
                'attribute' => 'email',
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
            ],
            [
                'label' => 'CPF/CNPJ',
                'attribute' => 'cpf_cnpj',
                'value' => function ($row) {
                    return Formatter::asCpfCnpj($row->cpf_cnpj, true, false);
                },
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
            ],
        ]
    ]) !!}
@stop
