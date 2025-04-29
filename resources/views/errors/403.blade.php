<!DOCTYPE html>
<html lang="es">
<head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-custom-red {
            background-color: #e00037;
        }
        .bg-custom-red-dark:hover {
            background-color: #c80033;
        }
    </style>

    <title>403 - Acceso Prohibido</title>
</head>
<body class="bg-light d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <div class="container text-center">
        <img src="{{ asset('images/logo_v2.png') }}" alt="Logo" class="mb-4 img-fluid" style="max-width: 16rem;">
        
        <h1 class="display-1 fw-bold text-dark">403</h1>
        <h2 class="h2 h-md-1 fw-bold text-secondary mt-3">
            ¡Acceso Prohibido!
        </h2>
        <p class="text-muted mt-4 mb-4">
            Lo sentimos, no tienes permisos para acceder a esta página.
        </p>        
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            <a href="{{ route('home') }}" class="btn bg-custom-red text-white px-4 py-2 bg-custom-red-dark">
                <i class="bi bi-house-door"></i>&nbsp;Volver al inicio
            </a>            
            <button onclick="window.history.back()" class="btn btn-secondary px-4 py-2">
                <i class="bi bi-arrow-left"></i>&nbsp;Regresar
            </button>
        </div>
    </div>
</body>
</html>
