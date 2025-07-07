@extends('layouts.base')
@push('scripts')
<script src="{{asset('js/filtroMazos.js')}}" type="module"></script>
@endpush
@section('titulo','mulligan.gg - Ver mazos')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error) <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@csrf
<section class="seccion-principal container">
    <div class=" m-4 d-flex flex-wrap justify-content-between">
        <h2>Todos los mazos</h2>
        <div class="filtro-mazos">
            <select name="filtro-mazos" id="filtro-mazos">
            @php
                $comandantes = array();
                foreach ($decks as $deck) {
                    if(!in_array($deck->commander, $comandantes)){
                        $comandantes[] = $deck->commander;
                        echo '<option value="'.$deck->commander.'">'.$deck->commander.'</option>';
                    }
                }
            @endphp
            </select>
            <button id="btnFiltroMazos" class="btn btn-primary btn-sm">Filtrar</button>
            <button id="btnReiniciarFiltro" class="btn btn-secondary btn-sm">Reiniciar</button>
        </div>
    </div>
    <hr>
    @if ($decks->isEmpty())
    <p>No existe ningun mazo.</p>
    @else
    <div class="container d-flex flex-wrap align-content-start">
        @foreach ($decks as $deck)
        <div class="carta-mazo col-12 col-sm-6 col-md-4 col-lg-3 mb-4 {{ str_replace(' ','-',str_replace(',','',$deck->commander)) }}"> <!-- Añadimos d-flex y align-items-stretch -->
            <div class="card m-2 mazo-lista" >
                <!-- Imagen del comandante -->
                @if ($deck->imagen_comandante)
                <img src="{{ $deck->imagen_comandante }}" class="card-img-top" alt="{{ $deck->commander }}">
                @else
                <p class="text-center p-3">Imagen no disponible</p>
                @endif

                <div class="card-body d-flex flex-column"> <!-- Añadimos d-flex y flex-column -->
                    <!-- Nombre del mazo -->
                    <h5 class="card-title">{{ $deck->name }}</h5>
                    <!-- Nombre del comandante -->
                    <p class="card-text"><strong>Comandante:</strong> {{ $deck->commander }}</p>
                    <!-- Botones para acciones -->
                    <div class="mt-auto"> <!-- Añadimos mt-auto para alinear los botones al final -->
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('decks.show', $deck->id) }}" class="btn btn-primary btn-sm">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</section>

@endsection