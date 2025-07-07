@extends('layouts.base')
@push('scripts')
<script src="{{ asset('js/searchbar.js') }}"></script>
<script src="{{ asset('js/validationEditDeck.js') }}"></script>
<script src="{{ asset('js/showPreview.js') }}" type="module"></script>
@endpush
@section('titulo','mulligan.gg - Editar mazo')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error) <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<section class="d-flex justify-content-evenly">
    <div class="row">
        <form action="/decks/{{$deck->id}}/update" method="post" class="col-12 col-lg-6">
            @csrf
            <fieldset>
                <legend>
                    <h3 class="mt-3">Editar mazo</h3>
                </legend>
                <div class="form-container ancho-500">
                    <div id="contenedorErrores"></div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label"><span class="text-danger">*</span>Nombre: </label>
                        <input type="text" class="form-control" name="nombre" id="nombre" value="{{$deck->name}}">
                    </div>
                    <div class="mb-3 search-container">
                        <label for="comandante" class="form-label"><span class="text-danger">*</span>Comandante: </label>
                        <input class="form-control" list="commanderResults" id="comandante" name="comandante" placeholder="Escribe el nombre del comandante..." value="{{$deck->commander}}">
                        <datalist id="commanderResults">
                        </datalist>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion: </label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3">{{$deck->description}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="listaMazo" class="form-label">Lista del mazo: </label>
                        <textarea class="form-control" name="listaMazo" id="listaMazo" rows="3">{{implode("\n",json_decode($deck->decklist))}}</textarea>
                    </div>
                    <div class="mb-3 search-container">
                        <label for="nuevaCarta" class="form-label">Añadir carta: </label>
                        <input class="form-control" list="cardResults" id="nuevaCarta" name="nuevaCarta" placeholder="Escribe el nombre de la carta...">
                        <datalist id="cardResults">
                        </datalist>
                        <div class="d-flex justify-content-evenly">
                            <button id="btnEditarMazo" class="btn-editar-mazo btn btn-secondary">Agregar carta</button>
                            <button id="btnActualizar" class="btn-editar-mazo btn btn-secondary">Actualizar preview</button>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-center">
                    <button id="btnEditarMazo" type="submit" class="btn-editar-mazo btn btn-primary">Guardar mazo</button>
                    <a id="btnEditarMazo" class="btn-editar-mazo btn btn-danger text-center" href="/ver-perfil">Cancelar</a>
                    </div>
                </div>
            </fieldset>
        </form>
        <div class="preview-section col-12 col-lg-6 mt-3">
            <div id="contenedor-categorias" class="form-container  ancho-500"></div>
        </div>
    </div>
</section>
@endsection