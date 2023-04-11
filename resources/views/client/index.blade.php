<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {!! grid_view([
                        'dataProvider' => $dataProvider,
                        'useFilters' => true,
                        'columnFields' => [
                            [
                                'label' => 'Actions',
                                'class' => Itstructure\GridView\Columns\ActionColumn::class,
                                'actionTypes' => [
                                    'view',
                                    'edit' => function ($data) {
                                        return '/admin/pages/' . $data->id . '/edit';
                                    },
                                    [
                                        'class' => Itstructure\GridView\Actions\Delete::class,
                                        'url' => function ($data) {
                                            return '/admin/pages/' . $data->id . '/delete';
                                        },
                                        'htmlAttributes' => [
                                            'target' => '_blank',
                                            'style' => 'color: yellow; font-size: 16px;',
                                            'onclick' => 'return window.confirm("Are you sure you want to delete?");'
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'label' => 'Código',
                                'attribute' => 'id',
                                'filter' => [
                                    'class' => Itstructure\GridView\Filters\DropdownFilter::class,
                                ]
                            ],
                            [
                                'label' => 'First Name',
                                'attribute' => 'first_name',
                            ],
                            [
                                'label' => 'Last Name',
                                'value' => function ($row) {
                                    return $row->last_name;
                                },
                                'sort' => 'last_name'
                            ],
                        ]
                    ]) !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
