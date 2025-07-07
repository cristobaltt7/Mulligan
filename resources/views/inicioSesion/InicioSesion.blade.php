@extends('layouts.base')
@section('titulo', 'mulligan.gg - Iniciar sesion')
@section('content')
<div class="form-container mt-5 ancho-500">
    <h2>Iniciar Sesión</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('iniciarSesion') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de Usuario</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="d-flex justify-content-evenly">
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            <a href="{{ route('crear.perfil') }}"><button type="button" class="btn btn-secondary">Registrarse</button></a>
        </div>

    </form>
</div>
@endsection