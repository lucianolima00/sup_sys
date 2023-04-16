@php use App\Widgets\Formatter; @endphp

@extends('layouts.interface')

@section('title', 'Clientes')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb d-flex align-items-center justify-content-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Listagem') }}
                </h2>
            </div>
            <div>
                <a class="btn btn-success" href="{{ route('clients.create') }}" title="Adicionar um cliente"> <i
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
                        return route('clients.edit', ['client' => $data]);
                    },
                    [
                        'class' => Lucianolima00\GridView\Actions\Delete::class, // Required
                        'url' => function ($data) {
                            return route('clients.destroy', ['client' => $data]);
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
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\TextFilter::class,
                    'cssClass' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
                ]
            ],
            [
                'label' => 'Nome fantasia',
                'attribute' => 'name',
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\TextFilter::class,
                    'cssClass' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
                ]
            ],
            [
                'label' => 'Razão social',
                'attribute' => 'company_name',
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\TextFilter::class,
                    'cssClass' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
                ]
            ],
            [
                'label' => 'CPF/CNPJ',
                'attribute' => 'cpf_cnpj',
                'value' => function ($row) {
                    return Formatter::asCpfCnpj($row->cpf_cnpj, true, false);
                },
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\TextFilter::class,
                    'cssClass' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
                ]
            ],
            [
                'label' => 'Telefone',
                'attribute' => 'phone',
                'value' => function ($row) {
                    return Formatter::asPhone($row->phone);
                },
                'filter' => [
                    'class' => Lucianolima00\GridView\Filters\TextFilter::class,
                    'cssClass' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm',
                ]
            ],
        ]
    ]) !!}
@stop
