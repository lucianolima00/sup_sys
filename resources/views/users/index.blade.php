@php use App\Widgets\Formatter; @endphp

@extends('layouts.interface')

@section('title', 'Usuários')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb d-flex align-items-center justify-content-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Listagem') }}
                </h2>
            </div>
            <div>
                <a class="btn btn-success" href="{{ route('users.create') }}" title="Adicionar um usuário"> <i
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
                        return route('users.edit', ['user' => $data]);
                    },
                    [
                        'class' => Lucianolima00\GridView\Actions\Delete::class, // Required
                        'url' => function ($data) {
                            return route('users.destroy', ['user' => $data]);
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
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\TextFilter::class,
                    'cssClass' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
                ]
            ],
            [
                'label' => 'Nome',
                'attribute' => 'name',
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\TextFilter::class,
                    'cssClass' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
                ],
            ],
            [
                'label' => 'Email',
                'attribute' => 'email',
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\TextFilter::class,
                    'cssClass' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
                ]
            ],
            [
                'label' => 'Administrador',
                'attribute' => 'admin',
                'value' => function ($row) {
                    return Arr::get(['Não', 'Sim'], $row->admin);
                },
                'htmlAttributes' => [
                    'style' => 'padding-right: 2rem'
                ],
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\TextFilter::class,
                    'cssClass' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
                ]
            ],
        ]
    ]) !!}
@stop
