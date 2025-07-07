@extends('layouts.base')
@push('scripts')
<script src="{{asset('js/showCards.js')}}" type="module"></script>
@endpush
@section('titulo','mulligan.gg - Ver mazo')
@section('content')
@csrf
<section class="seccion-principal">
    <div class="row verMazo">
        <div class="form-container altura-minima col-12 col-lg-3">
            <h5>Ver mazo</h5>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre: </label>
                <input type="text" class="form-control input-disabled" name="nombre" id="nombre" value="{{$deck->name}}" readonly disabled>
            </div>
            <div class="mb-3 search-container">
                <label for="comandante" class="form-label">Comandante: </label>
                <input type="text" class="form-control input-disabled" name="comandante" id="comandante" value="{{$deck->commander}}" readonly disabled>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripcion: </label>
                <textarea class="form-control input-disabled" name="descripcion" id="descripcion" rows="3" readonly disabled>{{$deck->description}}</textarea>
            </div>
            <div class="mb-3">
                Propiedad de <a href="/ver-perfil/{{$deck->owner_name}}">{{$deck->owner_name}}</a>
            </div>
        </div>
        <div class="form-container col-12 col-lg-8">
            <div id="contenedor-categorias">
            </div>
        </div>
    </div>
    <div id="contenedor"></div>
</section>

@endsection