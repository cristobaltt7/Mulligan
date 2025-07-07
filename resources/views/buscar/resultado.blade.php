@extends('layouts.base')
@push('scripts')
    <script src="{{ asset('js/filtroBusqueda.js') }}"></script>
@endpush

@section('titulo', 'mulligan.gg - Resultados de Búsqueda')

@section('content')
    <div class="container mt-4">

        @if(empty($resultados))
            <p>No se encontraron resultados.</p>
        @endif
        <div class="row">
            <div class="col-md-3">
                <!-- Formulario de búsqueda avanzada -->
                <form id="filterForm" data-search-url="{{ route('buscarResultados') }}">
                    <div class="mb-3">
                        <input type="text" id="searchQuery" name="q" class="form-control" placeholder="Nombre de la carta"
                            value="{{ request('q') }}">
                    </div>
                    <div class="mb-3">
                        <select id="rarity" class="form-select" name="rarity">
                            <option value="">Rareza</option>
                            <option value="common" {{ request('rarity') == 'common' ? 'selected' : '' }}>Común</option>
                            <option value="uncommon" {{ request('rarity') == 'uncommon' ? 'selected' : '' }}>Infrecuente
                            </option>
                            <option value="rare" {{ request('rarity') == 'rare' ? 'selected' : '' }}>Rara</option>
                            <option value="mythic" {{ request('rarity') == 'mythic' ? 'selected' : '' }}>Mítica</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select id="type" class="form-select" name="type">
                            <option value="">Tipo</option>
                            <option value="creature" {{ request('type') == 'creature' ? 'selected' : '' }}>Criatura</option>
                            <option value="instant" {{ request('type') == 'instant' ? 'selected' : '' }}>Instantáneo</option>
                            <option value="sorcery" {{ request('type') == 'sorcery' ? 'selected' : '' }}>Conjuro</option>
                            <option value="artifact" {{ request('type') == 'artifact' ? 'selected' : '' }}>Artefacto</option>
                            <option value="enchantment" {{ request('type') == 'enchantment' ? 'selected' : '' }}>Encantamiento
                            </option>
                            <option value="planeswalker" {{ request('type') == 'planeswalker' ? 'selected' : '' }}>
                                Planeswalker</option>
                            <option value="land" {{ request('type') == 'land' ? 'selected' : '' }}>Tierra</option>
                        </select>
                    </div>
                    <div class="row mb-5 align-items-center">
                        <label class="col-auto fw-bold">Color:</label>
                        <div class="col d-flex flex-wrap gap-3">
                            @php
                                $selectedColors = str_split(request('color', ''));
                            @endphp
                            <div class="form-check">
                                <input type="checkbox" name="color[]" value="W" {{ in_array('W', $selectedColors) ? 'checked' : '' }}> Blanco
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="color[]" value="U" class="ms-2" {{ in_array('U', $selectedColors) ? 'checked' : '' }}> Azul
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="color[]" value="B" class="ms-2" {{ in_array('B', $selectedColors) ? 'checked' : '' }}> Negro
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="color[]" value="R" class="ms-2" {{ in_array('R', $selectedColors) ? 'checked' : '' }}> Rojo
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="color[]" value="G" class="ms-2" {{ in_array('G', $selectedColors) ? 'checked' : '' }}> Verde
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary w-100" onclick="applyFilters()">Filtrar</button>
                </form>
            </div>
            <div class="col-md-9">
                <h1 class="mb-4">Resultados de Búsqueda</h1>
                <div id="resultsContainer">
                    @if(empty($resultados))
                        <p>No se encontraron resultados.</p>
                    @else
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            @foreach($resultados as $carta)
                                <div class="col">
                                    <div class="card h-100">
                                        @php
                                        $nombreCambiado = str_replace('//',  ' ',  $carta['name']);
                                        @endphp
                                        <a href="{{ route('verCarta', ['nombre' => $nombreCambiado]) }}">

                                            @if(isset($carta['card_faces']))
                                                <img src="{{ $carta['card_faces'][0]['image_uris']['normal'] }}"
                                                    class="card-img-top cart-busqueda" alt="{{ $carta['name'] }}">
                                            @else
                                                <img src="{{ $carta['image_uris']['normal'] }}" class="card-img-top cart-busqueda"
                                                    alt="{{ $carta['name'] }}">

                                            @endif

                                        </a>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $carta['name'] }}</h5>
                                            <p class="card-text">{{ $carta['set_name'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection