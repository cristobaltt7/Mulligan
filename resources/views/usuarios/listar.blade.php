@extends('layouts.base') <!-- Extiende la plantilla base -->

@push('scripts') <!-- Sección para agregar scripts adicionales -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Incluye jQuery -->
<script src="{{ asset('js/filtroUsuarios.js') }}"></script> <!-- Incluye el script para filtrar usuarios -->
@endpush

@section('titulo', 'mulligan.gg - Gestionar usuarios') <!-- Define el título de la página -->

@section('content') <!-- Inicia la sección de contenido -->

<div class="form-container ancho-750"> <!-- Contenedor principal del formulario -->
    <div class="d-flex justify-content-between align-items-center mb-3"> <!-- Encabezado y filtros -->
        <h2>Gestionar usuarios</h2> <!-- Título de la sección -->

        <!-- Contenedor para el filtro de usuarios -->
        <div class="filtro-usuarios d-flex align-items-center">
            <!-- Selector para filtrar por nombre de usuario -->
            <select name="filtro-usuarios" id="filtro-usuarios" class="form-select form-select-sm me-2">
                <option value="">Todos</option> <!-- Opción para mostrar todos los usuarios -->
                @php
                    $nombresUsuarios = []; // Array para almacenar nombres de usuarios únicos
                    foreach ($usuarios as $usuario) {
                        if (!in_array($usuario->username, $nombresUsuarios)) {
                            $nombresUsuarios[] = $usuario->username; // Agrega el nombre de usuario al array
                            echo '<option value="' . $usuario->username . '">' . $usuario->username . '</option>'; // Muestra opción en el selector
                        }
                    }
                @endphp
            </select>
            <!-- Botón para aplicar el filtro -->
            <button id="btnFiltroUsuarios" class="btn btn-primary btn-sm me-2" style="padding: 0.40rem 0.7rem; font-size: 0.8rem;">Filtrar</button>
            <!-- Botón para reiniciar el filtro -->
            <button id="btnReiniciarFiltro" class="btn btn-secondary btn-sm" style="padding: 0.40rem 0.7rem; font-size: 0.8rem;">Reiniciar</button>
        </div>
    </div>

    <!-- Tabla para mostrar la lista de usuarios -->
    <table class="tabla-usuarios table table-striped table-sm">
        <thead> <!-- Encabezado de la tabla -->
            <tr>
                <th>ID</th> <!-- Columna para el ID del usuario -->
                <th>Nombre</th> <!-- Columna para el nombre de usuario -->
                <th>Email</th> <!-- Columna para el email del usuario -->
                <th>Rol</th> <!-- Columna para el rol del usuario -->
                <th>Acciones</th> <!-- Columna para las acciones (ver, editar, borrar) -->
            </tr>
        </thead>
        <tbody> <!-- Cuerpo de la tabla -->
            @foreach ($usuarios as $usuario) <!-- Itera sobre cada usuario -->
            <tr class="fila-usuario {{ str_replace(' ', '-', $usuario->username) }}"> <!-- Fila de la tabla con clase dinámica -->
                <td>{{ $usuario->id }}</td> <!-- Muestra el ID del usuario -->
                <td>{{ $usuario->username }}</td> <!-- Muestra el nombre de usuario -->
                <td>{{ $usuario->email }}</td> <!-- Muestra el email del usuario -->
                <td>{{ $usuario->role }}</td> <!-- Muestra el rol del usuario -->
                <td> <!-- Columna de acciones -->
                    <!-- Botón para ver el perfil del usuario -->
                    <a class="btn btn-primary btn-sm" href="/ver-perfil/{{ $usuario->username }}">Ver</a>
                    <!-- Botón para editar el perfil del usuario -->
                    <a class="btn btn-primary btn-sm" href="{{ route('editar.perfil', ['username' => $usuario->username]) }}">Editar</a>
                    <!-- Botón para eliminar el perfil del usuario -->
                    <a class="btn btn-danger btn-sm" href="{{ route('eliminar.perfil', ['username' => $usuario->username]) }}">Borrar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection <!-- Finaliza la sección de contenido -->