@extends('layouts.base') <!-- Extiende la plantilla base -->

@section('titulo', 'mulligan.gg - Ver perfil') <!-- Define el título de la página -->

@section('content') <!-- Inicia la sección de contenido -->
    <div class="container"> <!-- Contenedor principal -->
        <!-- Encabezado y botones alineados a la derecha -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Perfil de {{ $usuario->username }}</h1> <!-- Título del perfil -->
            @if ($esMiPerfil || $esAdmin) <!-- Verifica si el usuario es el dueño del perfil o un administrador -->
                <div>
                    <!-- Botón para editar el perfil -->
                    <a href="{{ route('editar.perfil', ['username' => $usuario->username]) }}" class="btn btn-primary">Editar Perfil</a>
                    <!-- Botón para eliminar la cuenta -->
                    <a href="{{ route('eliminar.perfil', ['username' => $usuario->username]) }}" class="btn btn-danger">Eliminar Cuenta</a>
                </div>
            @endif
        </div>

        <!-- Información del usuario -->
        <div class="mb-4">
            <p><strong>Nombre de usuario:</strong> {{ $usuario->username }}</p> <!-- Muestra el nombre de usuario -->
            <p><strong>Correo:</strong> {{ $usuario->email }}</p> <!-- Muestra el correo electrónico -->
        </div>

        <!-- Lista de mazos -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Mis Mazos</h2> <!-- Título de la sección de mazos -->
            @if ($esMiPerfil || $esAdmin) <!-- Verifica si el usuario es el dueño del perfil o un administrador -->
                <!-- Botón para crear un nuevo mazo -->
                <a href="{{ route('decks.create') }}" class="btn btn-primary">Crear Nuevo Mazo</a>
            @endif
        </div>
        <hr> <!-- Línea horizontal para separar secciones -->

        <!-- Verifica si hay mazos para mostrar -->
        @if ($mazos->isEmpty())
            <p>No tienes ningún mazo creado.</p> <!-- Mensaje si no hay mazos -->
        @else
            <div class="row"> <!-- Contenedor para las tarjetas de mazos -->
                @foreach ($mazos as $mazo) <!-- Itera sobre cada mazo -->
                    <div class="col-md-4 mb-4 d-flex align-items-stretch"> <!-- Columna para cada mazo -->
                        <div class="card" style="width: 20rem;"> <!-- Tarjeta para el mazo -->
                            <!-- Imagen del comandante -->
                            @if ($mazo->imagen_comandante)
                                <img src="{{ $mazo->imagen_comandante }}" class="card-img-top" alt="{{ $mazo->commander }}">
                            @else
                                <p class="text-center p-3">Imagen no disponible</p> <!-- Mensaje si no hay imagen -->
                            @endif

                            <div class="card-body d-flex flex-column"> <!-- Cuerpo de la tarjeta -->
                                <!-- Nombre del mazo -->
                                <h5 class="card-title">{{ $mazo->name }}</h5>

                                <!-- Nombre del comandante -->
                                <p class="card-text"><strong>Comandante:</strong> {{ $mazo->commander }}</p>

                                <!-- Botones para acciones -->
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-center">
                                        <!-- Botón "Ver" -->
                                        <a href="{{ route('decks.show', $mazo->id) }}" class="btn btn-primary btn-sm m-1">Ver</a>

                                        <!-- Botón "Editar" (solo para el dueño del perfil o administrador) -->
                                        @if ($esMiPerfil || $esAdmin)
                                        <a href="{{ route('decks.edit', $mazo->id) }}" class="btn btn-secondary btn-sm m-1">Editar</a>

                                        <!-- Botón "Eliminar" (solo para el dueño del perfil o administrador) -->
                                        <a href="{{ route('decks.delete.confirm', $mazo->id) }}"
                                            class="btn btn-danger btn-sm m-1">Eliminar</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection <!-- Finaliza la sección de contenido -->