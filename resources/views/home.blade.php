@extends('layouts.terminos')
@extends('layouts.app_home')

@section('selector')
    
    <!-- Contenido del selector de ciudades -->
    <div class="location-selector">
        <i class="fas fa-map-marker-alt"></i>
        <form id="location-form" action="/inicio" method="POST">
            @csrf
            <select id="ciudad" name="ciudad" required>
                <option value="" disabled selected>Seleccionar ubicación</option>
                @foreach($ciudades as $ciudad)
                    <option value="{{ strtolower($ciudad->url) }}">{{ ucfirst($ciudad->nombre) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-location">ENTRAR</button>
        </form>
    </div>

@endsection

@section('content')
    <div class="swiper home-swiper">
        <div class="swiper-wrapper">
            @foreach($tarjetas as $tarjeta)
                <div class="swiper-slide">
                    <div class="card home-card carru">
                        <a href="{{ $tarjeta->link }}" class="card-link">
                            <img src="{{ asset('storage/' . $tarjeta->imagen) }}" alt="{{ $tarjeta->titulo }}">
                            <div class="card-content">
                                <p>{{ $tarjeta->descripcion }}</p>
                                <h3>{{ $tarjeta->titulo }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Paginación -->
        <div class="swiper-pagination"></div>
    </div>

    <!-- Encabezado H2 con texto descriptivo -->
    <div class="wrapper">
        <div class="glass-container">
            <h2 class="mission-title">{{ $meta->heading_h2_secondary }}</h2>
            <div class="content-wrapper">
                <div class="mission-text" id="mission-text">
                    <span id="texto-corto">{{ Str::limit($meta->additional_text, 350) }}</span>
                    <span id="texto-completo" style="display: none;">{!! $meta->additional_text !!}</span>                    
                </div>                
                <button id="btn-ver-mas" class="btn-glass" onclick="toggleText();">Ver más</button>
            </div>
        </div>
    </div>
        
@endsection


