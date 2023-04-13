@extends('layouts.interface')

@section('title', 'Colaboradores')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Cadastrar colaborador') }}
                </h2>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <form method="POST" action="{{ route('collaborators.store') }}">
            @csrf
            @include('collaborators._form')
        </form>
    </div>
@stop
