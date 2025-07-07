@extends('layouts.base') <!-- Extiende la plantilla base -->

@section('titulo', 'mulligan.gg - Crear perfil') <!-- Define el título de la página -->

@section('content') <!-- Inicia la sección de contenido -->
<h2>Crear Usuario</h2> <!-- Título de la página -->

<!-- Contenedor principal del formulario -->
<div class="container">
    <div class="row justify-content-center"> <!-- Centrar el contenido -->
        <div class="col-md-8"> <!-- Definir el ancho del formulario -->
            <div class="card shadow"> <!-- Tarjeta con sombra -->
                <div class="card-header text-white" style="background-color: #589c8d;"> <!-- Encabezado de la tarjeta -->
                    <h2 class="mb-0">Crear Usuario</h2> <!-- Título del formulario -->
                </div>
                <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                    <!-- Mostrar mensajes de error si existen -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li> <!-- Mostrar cada error en una lista -->
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulario para crear un usuario -->
                    <form action="{{ route('guardar.usuario') }}" method="POST">
                        @csrf <!-- Token CSRF para protección -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de usuario</label> <!-- Etiqueta para el campo de nombre de usuario -->
                            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required> <!-- Campo de entrada para el nombre de usuario -->
                            @error('username')
                                <div class="text-danger">{{ $message }}</div> <!-- Mostrar error de validación para el nombre de usuario -->
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label> <!-- Etiqueta para el campo de email -->
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required> <!-- Campo de entrada para el email -->
                            @error('email')
                                <div class="text-danger">{{ $message }}</div> <!-- Mostrar error de validación para el email -->
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label> <!-- Etiqueta para el campo de contraseña -->
                            <input type="password" name="password" id="password" class="form-control" required> <!-- Campo de entrada para la contraseña -->
                            @error('password')
                                <div class="text-danger">{{ $message }}</div> <!-- Mostrar error de validación para la contraseña -->
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label> <!-- Etiqueta para el campo de confirmación de contraseña -->
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required> <!-- Campo de entrada para confirmar la contraseña -->
                        </div>
                        <div class="d-grid gap-2"> <!-- Contenedor para los botones -->
                            <button type="submit" class="btn btn-primary">Crear Cuenta</button> <!-- Botón para enviar el formulario -->
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a> <!-- Botón para cancelar y volver atrás -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir script para validar la creación de usuarios -->
<script src="{{ asset('js/validarCreacionUsuarios.js') }}"></script>

@endsection <!-- Finaliza la sección de contenido -->