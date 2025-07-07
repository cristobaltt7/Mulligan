@extends('layouts.base')
@section('titulo', 'mulligan.gg - Eliminar mazo')
@section('content')
    <div class="container">
        <div class="card shadow-sm mx-auto mt-5" style="max-width: 500px;">
            <div class="card-header" style="background-color: #e96060; color: white;">
                <h4 class="card-title mb-0">Borrar mazo</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('decks.destroy.confirm', $deck->id) }}" method="POST">
                    @csrf
                    <fieldset>
                        <div class="mb-4">
                            <label class="form-label">
                                <strong>Va a eliminar {{ $deck->name }}.</strong><br>
                                Esta acción no tiene vuelta atrás. Debe confirmar la eliminación para continuar:
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="confirmacion" id="y" value="true">
                                <label class="form-check-label" for="y">
                                    Sí, quiero eliminar el mazo.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="confirmacion" id="n" value="false" checked>
                                <label class="form-check-label" for="n">
                                    No, no quiero borrar el mazo.
                                </label>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger btn-lg">
                                Borrar mazo
                            </button>
                            <a href="{{ route('ver.perfil') }}" class="btn btn-secondary btn-lg">
                                Cancelar
                            </a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection