@extends('layouts.base') <!-- Extiende la plantilla base -->

@section('titulo', 'mulligan.gg - Editar perfil') <!-- Define el título de la página -->

@section('content') <!-- Inicia la sección de contenido -->

    <!-- Enlace al archivo CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <!-- Contenedor principal del formulario -->
    <div class="container">
        <div class="row justify-content-center"> <!-- Centrar el contenido -->
            <div class="col-md-8"> <!-- Definir el ancho del formulario -->
                <div class="card shadow"> <!-- Tarjeta con sombra -->
                    <div class="card-header text-white" style="background-color: #589c8d;"> <!-- Encabezado de la tarjeta -->
                        <h2 class="mb-0">Editar Perfil</h2> <!-- Título del formulario -->
                    </div>
                    <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                        
                        <!-- Contenedor para mostrar errores -->
                        <div id="errorContainer">
                            @if ($errors->any()) <!-- Verifica si hay errores de validación -->
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li> <!-- Mostrar cada error en una lista -->
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <!-- Formulario para editar el perfil -->
                        <form id="formulario-editar-perfil" 
                            action="{{ route('editar.perfil', ['username' => $usuario->username]) }}" method="POST">
                            @csrf <!-- Token CSRF para protección -->
                            @method('PUT') <!-- Usamos PUT para actualizar el perfil -->

                            <!-- Campo para el nombre de usuario -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de usuario</label> <!-- Etiqueta para el campo de nombre de usuario -->
                                <input type="text" name="username" id="username" class="form-control"
                                    value="{{ old('username', $usuario->username) }}" required> <!-- Campo de entrada para el nombre de usuario -->
                            </div>

                            <!-- Campo para el email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label> <!-- Etiqueta para el campo de email -->
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $usuario->email) }}" required> <!-- Campo de entrada para el email -->
                            </div>

                            <!-- Campo para la nueva contraseña (opcional) -->
                            <div class="mb-3">
                                <label for="password_nueva" class="form-label">Nueva contraseña (opcional)</label> <!-- Etiqueta para el campo de nueva contraseña -->
                                <input type="password" name="password_nueva" id="password_nueva" class="form-control"> <!-- Campo de entrada para la nueva contraseña -->
                            </div>

                            <!-- Campo para confirmar la nueva contraseña -->
                            <div class="mb-3">
                                <label for="password_confirmacion" class="form-label">Confirmar nueva contraseña</label> <!-- Etiqueta para el campo de confirmación de contraseña -->
                                <input type="password" name="password_nueva_confirmation" id="password_confirmacion"
                                    class="form-control" disabled> <!-- Campo de entrada para confirmar la nueva contraseña (inicialmente deshabilitado) -->
                            </div>

                            <!-- Botones para enviar el formulario o cancelar -->
                            <div class="d-grid gap-2"> <!-- Contenedor para los botones -->
                                <button type="submit" class="btn btn-primary">Actualizar perfil</button> <!-- Botón para enviar el formulario -->
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a> <!-- Botón para cancelar y volver atrás -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir script para validar la edición del perfil -->
    <script src="{{ asset('js/editarPerfil.js') }}"></script>

@endsection <!-- Finaliza la sección de contenido -->