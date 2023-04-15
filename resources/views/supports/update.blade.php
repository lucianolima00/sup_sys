@extends('layouts.interface')

@section('title', 'Chamados')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Atualizar chamado') }}
                </h2>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('supports.update', ['support' => $support]) }}">
        @csrf
        <div class="row">
            @include('supports._form')
        </div>
    </form>
@stop
