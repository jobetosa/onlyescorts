@extends('layouts.app_login')

@section('title', 'OnlyEscorts | Login')

@section('description', 'Accede a tu cuenta para gestionar tus servicios. Inicia sesión de forma segura y sin interrupciones.')

@section('content')
<div class="login-container">
    <!-- Logo y Título fuera de la caja -->
    <div class="logo-title-container">
        <div class="logo">
            <img class="only" src="{{ asset('images/logo_XL-2.png') }}" alt="Logo">
        </div>
        <h1 class="title" hidden>Login</h1>
        <h2 class="title">Mi cuenta</h2>
    </div>

    <div class="login-box">
        <!-- Mostrar el mensaje de error si las credenciales no son correctas -->
        @if ($errors->has('email'))
            <div class="alert alert-danger">
                {{ $errors->first('email') }}
            </div>
        @endif

        <form method="POST" class="pt-5" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <input id="email" type="email" class="form-control" name="email" placeholder=" " value="{{ old('email') }}" required autofocus>
                <label for="email" class="floating-label">Nombre de usuario <span class="required">*</span></label>
            </div>
            <div class="form-group mb-3">
                <input id="password" type="password" class="form-control" name="password" placeholder=" " required>
                <label for="password" class="floating-label">Contraseña <span class="required">*</span></label>
            </div>                        
            <!-- Recordarme -->
            <div class="form-group mb-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" style="width: auto;">&nbsp;Recordarme
                    </label>
                </div>
            </div>

            <!-- Botón de Acceder -->
            <div class="form-group">
                <button type="submit" class="btn login-btn">Acceder</button>
            </div>            
        </form>

        <!-- Olvidaste tu contraseña -->
        <a href="{{ route('password.request') }}" class="forgot-link text-center">Olvidaste tu contraseña</a>

        <!-- Sección de "Registrarse ahora" -->
        <div class="register-link">
            <p>
                ¿Primera vez en Only Escorts?
                <br>
                <a href="{{ route('register') }}" class="register-now">Registrarse ahora</a></p>
        </div>
    </div>
</div>
@endsection
