@extends('layouts.base')
@push('scripts')
<script src="{{ asset('js/searchbar.js')}}"></script>
<script src="{{ asset('js/validationCreateDeck.js')}}"></script>
@endpush
@section('titulo','mulligan.gg - Crear mazo')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error) <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<section>
<form action="/decks/store" method="post">
    @csrf
    <fieldset>
        <div class="form-container ancho-500">
        <legend>Crear mazo</legend>
        <div id="contenedorErrores"></div>
            <div class="mb-3">
                <label for="nombre" class="form-label"><span class="text-danger">*</span>Nombre: </label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Escribe el nombre del mazo...">
            </div>
            <div class="mb-3 search-container">
                <label for="comandante" class="form-label"><span class="text-danger">*</span>Comandante: </label>
                <input class="form-control" list="commanderResults" id="comandante" name="comandante" placeholder="Escribe el nombre del comandante...">
                <datalist id="commanderResults">
                </datalist>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion: </label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Escribe la descripcion del mazo..."></textarea>
            </div>
            <button id="btnCrearMazo" type="submit" class="btn btn-primary" style="margin-top: 15px;">Crear mazo</button>
    <div id="errores" class="mb-3"></div>
        </div>
        </fieldset>
</form>
</setcion>
@endsection