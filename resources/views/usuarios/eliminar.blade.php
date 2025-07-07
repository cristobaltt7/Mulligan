@extends('layouts.base') <!-- Extiende la plantilla base -->

@section('titulo', 'mulligan.gg - Eliminar perfil') <!-- Define el título de la página -->

@section('content') <!-- Inicia la sección de contenido -->

    <!-- Enlace al archivo CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <!-- Contenedor principal -->
    <div class="container">
        <h1>Confirmar eliminación de perfil</h1> <!-- Título de la página -->

        <!-- Contenedor para mostrar errores -->
        <div id="errorContainer"></div>

        <!-- Formulario para confirmar la eliminación del perfil -->
        <form action="{{ route('eliminar.perfil', ['username' => $usuario->username]) }}" method="POST" id="formEliminar">
            @csrf <!-- Token CSRF para protección -->
            @method('DELETE') <!-- Usamos DELETE para eliminar el perfil -->

            <!-- Mensaje de confirmación -->
            <p>¿Estás seguro de que deseas eliminar tu cuenta? Eso eliminará cualquier mazo asociado a tu cuenta. Escribe "ELIMINAR" en mayúsculas para confirmar.</p>

            <!-- Campo para confirmar la eliminación -->
            <input type="text" name="confirmar" required> <!-- El usuario debe escribir "ELIMINAR" para confirmar -->

            <!-- Botones de acciones -->
            <div class="mt-4">
                <button type="submit" class="btn btn-danger">Eliminar cuenta</button> <!-- Botón para eliminar la cuenta -->
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a> <!-- Botón para cancelar y volver atrás -->
            </div>
        </form>
    </div>

    <!-- Incluir el archivo JS para validar la eliminación -->
    <script src="{{ asset('js/eliminarPerfil.js') }}"></script>

@endsection <!-- Finaliza la sección de contenido -->