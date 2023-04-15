@extends('layouts.interface')

@section('title', 'Chamados')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Cadastrar chamado') }}
                </h2>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <form method="POST" action="{{ route('supports.store') }}">
            @csrf
            <div class="row">
                @include('supports._form')
            </div>
        </form>
    </div>
@stop
