@extends('layouts.base')

@push('scripts')
    <script src="{{ asset('js/listarMazos.js') }}"></script>
    <script src="{{ asset('js/mostrarOrbesEsp.js') }}" type="module"></script>
@endpush

@section('titulo', 'mulligan.gg - Detalles de la Carta')

@section('content')



    <div class="container mt-4">
        <h1 class="mb-4">{{ $carta['name'] }}</h1>

        <div class="row">
            <div class="col-md-4">
                @if(isset($carta['card_faces']))
                    <img src="{{ $carta['card_faces'][0]['image_uris']['normal'] ?? '#' }}" class="card-img-top cart-busqueda"
                        alt="{{ $carta['name'] }}">
                @else
                    <img src="{{ $carta['image_uris']['normal'] ?? '#' }}" class="card-img-top cart-busqueda"
                        alt="{{ $carta['name'] }}">

                @endif
                @if(Auth::check())
                    <div class="mt-4">
                        <form id="addToMazo" action="{{ route('add-card') }}" method="POST">
                            <input value="{{ $carta['name'] }}" type="hidden" name="card_name">
                            <label for="selectDeck" class="form-label"><strong>Agregar a mazo:</strong></label>
                            <select id="selectDeck" name="deck_id" class="form-select" data-user-id="{{ Auth::id() }}" required>
                                <option value="">Selecciona un mazo</option>
                            </select>
                            <button class="btn btn-primary mt-4" type="submit">Añadir al mazo</button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Nombre:</strong> {{ $carta['name'] }}</li>
                    <li id="costeMana" class="list-group-item"> {{ $carta['mana_cost'] ?? 'No disponible' }}</li>
                    <li class="list-group-item"><strong>Tipo:</strong> {{ $carta['type_line'] }}</li>
                    <li class="list-group-item"><strong>Rareza:</strong> {{ ucfirst($carta['rarity']) }}</li>
                    <li class="list-group-item"><strong>Set:</strong> {{ $carta['set_name'] }}</li>
                    <li id="textoReglas" class="list-group-item"> {{ $carta['oracle_text'] ?? 'No disponible' }}</li>
                    <li class="list-group-item"><strong>Texto de ambientación:</strong>
                        {{ $carta['flavor_text'] ?? 'No disponible' }}</li>
                    <li class="list-group-item"><strong>Precio en USD:</strong> ${{ $carta['prices']['usd'] ?? 'N/A' }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection