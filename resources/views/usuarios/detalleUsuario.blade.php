<!DOCTYPE html>
<html lang="es">
<head>
<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .user-details {
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
        }
        .user-details h1 {
            margin-top: 0;
        }
        .user-details p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="user-details">
        <h1>Detalle del Usuario</h1>
        <p><strong>ID:</strong> {{ $usuario->id }}</p>
        <p><strong>Username:</strong> {{ $usuario->username }}</p>
        <p><strong>Email:</strong> {{ $usuario->email }}</p>
        <p><strong>Rol:</strong> {{ $usuario->role }}</p>
        <p><strong>Creado en:</strong> {{ $usuario->created_at }}</p>
        <p><strong>Actualizado en:</strong> {{ $usuario->updated_at }}</p>
    </div>
</body>
</html>