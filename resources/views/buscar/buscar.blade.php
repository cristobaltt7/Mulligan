@extends('layouts.base')

@section('titulo', 'mulligan.gg - Buscar')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Buscar Cartas de Magic</h1>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="searchForm" action="{{ route('buscarResultados') }}" method="get">
            <div class="input-group mb-3">
                <input type="text" name="q" class="form-control" placeholder="Nombre de la carta" required>
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </form>
        <div class="imagenBuscador">
            <img rel="icon" type="image" class="imagenInicio" src="{{ asset('img/cart.png') }}">
        </div>
    </div>
@endsection