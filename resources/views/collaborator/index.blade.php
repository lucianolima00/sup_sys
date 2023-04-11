<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Colaboradores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row mb-4">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                    {{ __('Listagem') }}
                                </h2>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-success" href="" title="Create a collaborator"> <i class="fas fa-plus-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p></p>
                        </div>
                    @endif

                    <table class="table table-bordered table-responsive-lg">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>description</th>
                            <th>Price</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                        @foreach ($collaborators as $collaborator)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <form action="" method="POST">

                                        <a href="" title="show">
                                            <i class="fas fa-eye text-success  fa-lg"></i>
                                        </a>

                                        <a href="">
                                            <i class="fas fa-edit  fa-lg"></i>
                                        </a>

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" title="delete" style="border: none; background-color:transparent;">
                                            <i class="fas fa-trash fa-lg text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    {!! $collaborators->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
