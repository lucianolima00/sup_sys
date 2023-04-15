@extends('layouts.interface')

@section('title', 'Clientes')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Atualizar cliente') }}
                </h2>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('clients.update', ['client' => $client]) }}">
        @csrf
        <div class="row">
            @include('clients._form')
        </div>
    </form>
@stop
