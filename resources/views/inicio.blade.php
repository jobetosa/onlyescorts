@extends('layouts.app')

@section('content')

    <header class="banner">
        <img src="/images/banner1.jpg" alt="Banner Image" class="banner-img">
        <div class="banner-content">
            <div class="texto_banner">
                <div class="heading-container">
                    <h1 class="thin">
                        {{ $meta->heading_h1 ?? 'Encuentra tu' }}
                    </h1>
                    <h2 class="bold">
                        {{ $meta->heading_h2 ?? 'experiencia perfecta' }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="gradient"></div>
    </header>
    
    <!-- Sección de Historias -->
    <section class="estados-historias">
        <div class="container">
            <div class="historias-wrapper">
                <div class="historias-titulos">
                    <h4>ÚLTIMAS HISTORIAS</h4>
                    <a href="#" id="ver-todas-historias" class="ver-todas">Ver todas</a>
                </div>
                <div class="historias-container">
                    @if($estados->isEmpty())
                        <p class="no-historias">No hay historias disponibles</p>
                    @else
                        <div class="historias-scroll">
                            @php
                                $estadosAgrupados = $estados->groupBy('usuarios_publicate_id');
                                $index = 0;
                            @endphp

                            @foreach($estadosAgrupados as $usuarioId => $estadosUsuario)                            
                                @php
                                    $primerEstado = $estadosUsuario->first();
                                    $vistoPorUsuarioActual = $primerEstado->vistoPor
                                        ->where('id', auth()->id())
                                        ->isNotEmpty();
                                    $todasVistas = $estadosUsuario->every(function($estado) {
                                        return $estado->vistoPor->where('id', auth()->id())->isNotEmpty();
                                    });
                                @endphp

                                @if($primerEstado->usuarioPublicate)
                                    <div class="historia-item" data-index="{{ $index }}" data-usuario-id="{{ $usuarioId }}" data-estados='{{ json_encode($estadosUsuario) }}'>
                                        <div class="historia-circle {{ $todasVistas ? 'historia-vista todas-vistas' : ($vistoPorUsuarioActual ? 'historia-vista' : '') }}">
                                            @if($primerEstado->user_foto)
                                                <img src="{{ asset('storage/' . $primerEstado->user_foto) }}" loading="lazy" alt="{{ $primerEstado->usuarioPublicate->fantasia }}">
                                            @else
                                                <img src="{{ asset('storage/profile_photos/default-avatar.jpg') }}" loading="lazy" alt="{{ $primerEstado->usuarioPublicate->fantasia }}">
                                            @endif
                                        </div>

                                        <span class="historia-nombre">{{ ucfirst(Str::lower($primerEstado->usuarioPublicate->fantasia)) }}</span>
                                        <span class="historia-tiempo">hace {{ $primerEstado->created_at->diffForHumans(null, true) }}</span>
                                    </div>

                                    @php
                                        $index++;
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para las historias -->
    <div id="historiaModal" class="historia-modal">
        <div class="modal-contenido">
            <span class="cerrar-modal">&times;</span>
            <div class="modal-header">
                <div class="usuario-info">
                    <div class="usuario-avatar">
                        <a href="#" id="modal-usuario-picture" class="nombre-link">
                            <img id="modal-profile-image" src="" alt="Perfil">
                        </a>
                    </div>
                    <div class="usuario-detalles">
                        <a href="#" id="modal-usuario-nombre" class="nombre-link"></a>
                        <span id="modal-historia-tiempo"></span>
                    </div>
                </div>
            </div>
            <div class="modal-navigation">
                <button class="nav-btn prev-btn">&lt;</button>
                <button class="nav-btn next-btn">&gt;</button>
            </div>
            <div id="historia-contenido"></div>
            <div class="historia-indicators"></div>
        </div>
    </div>

    <main class="container-fluid px-5">
        <div class="row">
            <section class="inicio-usuarios-section col-md-10">
                <div class="inicio-card-wrapper w-100">
                    @include('components.breadcrumb')

                                        <!-- Contenedor del Carrusel -->
                    <div class="carousel-container">
                     <button class="carousel-button prev">&#10094;</button>
                        <div class="carousel-wrapper">
                            @php
                                //$enlace_actual = $_SERVER['PHP_SELF'];
                                $enlace_actual2 = request()->path();
                                $enlace_actual = str_replace("escorts-","",$enlace_actual2);
                                $enlace_actual = str_replace("-","",$enlace_actual);
                              
                                $antofagasta = '/escorts-antofagasta/';
                                $calama = '/escorts-calama/';
                                $chillan = '/escorts-chillan/';
                                $concepcion = '/escorts-concepcion/';
                                $copiapo = '/escorts-copiapo/';
                                $curico = '/escorts-curico/';
                                $iquique = '/escorts-iquique/';
                                $laserena = '/escorts-la-serena/';
                                $linares = '/escorts-linares/';
                                $losangeles = '/escorts-los-angeles/';
                                $osorno = '/escorts-osorno/';
                                $pucon = '/escorts-pucon/';
                                $puertomontt = '/escorts-puerto-montt/';
                                $puntaarenas = '/escorts-punta-arenas/';
                                $quilpue = '/escorts-quilpue/';
                                $rancagua = '/escorts-rancagua/';
                                $sanfernando = '/escorts-san-fernando/';
                                $santiago = '/escorts-santiago/';
                                $talca = '/escorts-talca/';
                                $temuco = '/escorts-temuco/';
                                $valdivia = '/escorts-valdivia/';
                                $vinadelmar = '/escorts-vina-del-mar/';

                                $enlaces = [
                                    'las-condes' => 'Escorts en Las Condes',
                                    'providencia' => 'Escorts en Providencia',
                                    'vitacura' => 'Escorts en Vitacura',
                                    'argentina' => 'Escort Argentina en Santiago',
                                    'chilena' => 'Putas Chilenas en Santiago',
                                    'colombiana' => 'Putas Colombianas en Santiago',
                                    'venezolana' => 'Escort Venezolana en Santiago',
                                    'under' => 'Escort Under en Santiago',
                                    'premium' => 'Escort Premium en Santiago',
                                    'vip' => 'Escort VIP Santiago',
                                    'de_lujo' => 'Escort de Lujo Santiago',
                                    'disponible' => 'Escorts WhatsApp en Santiago',
                                    'a-domicilio' => 'Escort a Domicilio en Santiago',
                                    'anal' => 'Escort Anal en Santiago',
                                    'masajes-eroticos' => 'Masajes Eróticos Santiago',
                                    'sexo-oral' => 'Sexo oral Santiago',
                                    'video-llamada' => 'Escort Videollamada en Santiago',
                                    'masajes-con-final-feliz' => 'Masajes con final feliz en Santiago',
                                    'trio' => 'Escort Trío en Santiago',
                                    'casa-propia' => 'Casa de Putas en Santiago',
                                    'con-videos' => 'Escort con video en Santiago',
                                    'culona' => 'Putas culonas en Santiago',
                                    'en-promocion' => 'Escort Promo en Santiago',
                                    'bajita' => 'Escort Enana en Santiago',
                                    'gordita' => 'Escort Gordita en Santiago',
                                    'independiente' => 'Escorts Independientes en Santiago',
                                    'joven' => 'Escort Jóvenes en Santiago',
                                    'madura' => 'Escort Madura en Santiago',
                                    'morena' => 'Putas morenas en Santiago',
                                    'negra' => 'Putas negras en Santiago',
                                    'rubia' => 'Escort Rubia en Santiago',
                                    'tetona' => 'Escort Tetona Santiago'
                                ];
                                $ciudades_modulo = [
                                    'antofagasta' => 'Antofagasta',
                                    'calama' => 'Calama',
                                    'chillan' => 'Chillán',
                                    'concepcion' => 'Concepción',
                                    'copiapo' => 'Copiapó',
                                    'curico' => 'Curicó',
                                    'iquique' => 'Iquique',
                                    'laserena' => 'La Serena',
                                    'linares' => 'Linares',
                                    'losangeles' => 'Los Ángeles',
                                    'osorno' => 'Osorno',
                                    'pucon' => 'Pucón',
                                    'puertomontt' => 'Puerto Montt',
                                    'puntaarenas' => 'Punta Arenas',
                                    'quilpue' => 'Quilpué',
                                    'rancagua' => 'Rancagua',
                                    'sanfernando' => 'San Fernando',
                                    'talca' => 'Talca',
                                    'temuco' => 'Temuco',
                                    'valdivia' => 'Valdivia',
                                    'vinadelmar' => 'Vina del Mar'
                                ];

                                $categorias = [
                                    'chilena' => 'Putas Chilenas',
                                    'colombiana' => 'Putas Colombianas',
                                    'venezolana' => 'Escort Venezolana',
                                    'disponible' => 'Escorts WhatsApp',
                                    'a-domicilio' => 'Escort a Domicilio',
                                    'anal' => 'Escort Anal',
                                    'masajes-eroticos' => 'Masajes Eróticos',
                                    'sexo-oral' => 'Sexo oral',
                                    'video-llamada' => 'Escort Videollamada',
                                    'masajes-con-final-feliz' => 'Masajes con final feliz',
                                    'trio' => 'Escort Trío',
                                    'casa-propia' => 'Casa de Putas',
                                    'con-videos' => 'Escort con video',
                                    'culona' => 'Putas culonas',
                                    'en-promocion' => 'Escort Promo',
                                    'bajita' => 'Escort Enana',
                                    'gordita' => 'Escort Gordita',
                                    'independiente' => 'Escorts Independientes',
                                    'joven' => 'Escort Jóvenes',
                                    'madura' => 'Escort Madura',
                                    'morena' => 'Putas morenas',
                                    'negra' => 'Putas negras',
                                    'rubia' => 'Escort Rubia',
                                    'tetona' => 'Escort Tetona'
                                ];
                                
                            function eliminar_acentos($cadena){
		
                            //Reemplazamos los espacion por -
                            $cadena = str_replace(
                                array(' '),
                                array('-'),
                                $cadena
                                );
                                
                            //Reemplazamos la A y a
                            $cadena = str_replace(
                            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                            $cadena
                            );

                            //Reemplazamos la E y e
                            $cadena = str_replace(
                            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                            $cadena );

                            //Reemplazamos la I y i
                            $cadena = str_replace(
                            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                            $cadena );

                            //Reemplazamos la O y o
                            $cadena = str_replace(
                            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                            $cadena );

                            //Reemplazamos la U y u
                            $cadena = str_replace(
                            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                            $cadena );

                            //Reemplazamos la N, n, C y c
                            $cadena = str_replace(
                            array('Ñ', 'ñ', 'Ç', 'ç'),
                            array('N', 'n', 'C', 'c'),
                            $cadena
                            );
                            
                            return $cadena;
                        }
                                
                            @endphp

                            @if (str_contains($enlace_actual, 'santiago')) 
                                @foreach ($enlaces as $slug => $texto)
                                <div class="carousel-item">
                                    <a href="{{ $santiago . $slug }}">{{ $texto }}</a>
                                </div>
                                @endforeach
                            @endif
                            
                            @foreach ($ciudades_modulo as $slug => $nombre)
                                @if (str_contains($enlace_actual, $slug))
                                    @foreach ($categorias as $categoria_slug => $categoria_nombre)
                                    <div class="carousel-item">
                                        <a href="{{ ${$slug} . $categoria_slug }}">{{ $categoria_nombre }} en {{ $nombre }}</a>
                                    </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                        <button class="carousel-button next">&#10095;</button>
                    </div>

                    <script>
                     document.addEventListener("DOMContentLoaded", function () {
                        const carousel = document.querySelector(".carousel-wrapper");
                        const prevButton = document.querySelector(".prev");
                        const nextButton = document.querySelector(".next");
                        const items = document.querySelectorAll(".carousel-item a");
                        const itemWidth = document.querySelector(".carousel-item").offsetWidth + 10;

                        let isDragging = false;
                        let startX, scrollLeft;
                        let moved = false;

                        function moveCarousel(direction) {
                           carousel.scrollBy({ left: direction * itemWidth, behavior: "smooth" });
                        }

                        prevButton.addEventListener("click", () => moveCarousel(-1));
                        nextButton.addEventListener("click", () => moveCarousel(1));

                        // FUNCIONALIDAD PARA ARRASTRAR CON EL MOUSE
                        carousel.addEventListener("mousedown", (e) => {
                           isDragging = true;
                           startX = e.clientX;
                           scrollLeft = carousel.scrollLeft;
                           moved = false;
                           carousel.style.cursor = "grabbing";
                           e.preventDefault(); 
                        });

                        document.addEventListener("mouseup", () => {
                           isDragging = false;
                           carousel.style.cursor = "grab";
                        });

                        document.addEventListener("mousemove", (e) => {
                           if (!isDragging) return;
                           const x = e.clientX;
                           const walk = (x - startX) * 1.5;
                           if (Math.abs(walk) > 5) moved = true;
                           carousel.scrollLeft = scrollLeft - walk;
                        });

                        // FUNCIONALIDAD PARA ARRASTRAR EN MÓVIL (TOUCH)
                        carousel.addEventListener("touchstart", (e) => {
                           isDragging = true;
                           startX = e.touches[0].clientX;
                           scrollLeft = carousel.scrollLeft;
                           moved = false;
                        });

                        carousel.addEventListener("touchend", (e) => {
                           isDragging = false;

                           // Si el usuario NO arrastró, permitir que el enlace funcione
                           if (!moved) {
                                 e.target.click();
                           }
                        });

                        carousel.addEventListener("touchmove", (e) => {
                           if (!isDragging) return;
                           const x = e.touches[0].clientX;
                           const walk = (x - startX) * 1.5;
                           if (Math.abs(walk) > 5) moved = true;
                           carousel.scrollLeft = scrollLeft - walk;
                           e.preventDefault(); // Evita el scroll en la página mientras se desliza
                        });

                        // SOLUCIÓN: PERMITIR CLICS SOLO SI NO SE ARRASTRÓ
                        items.forEach(item => {
                           item.addEventListener("click", (e) => {
                                 if (moved) {
                                    e.preventDefault(); // Bloquea el clic solo si hubo arrastre
                                 }
                           });
                        });

                     });
                    </script>

                    

                    <div class="inicio-card-container">
                        @if($usuarios->isEmpty())
                            <div class="no-results" style="width: 100%; text-align: center; padding: 2rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 1rem;">
                                <p style="font-size: 1.25rem; color: #666; margin-bottom: 1rem;">No encontramos resultados para tu búsqueda</p>
                                <p style="color: #888;">Intenta ajustar los filtros o realizar una nueva búsqueda</p>
                                <a href="{{ url()->current() }}" class="btn btn-primary" style="display: inline-block; margin-top: 1rem; padding: 0.5rem 1rem; background: #e00037; color: white; text-decoration: none; border-radius: 4px;">Ver todas</a>
                            </div>
                        @else
                            @foreach($usuarios as $usuario)
                                @php
                                    $fotos = json_decode($usuario->fotos, true);
                                    $positions = json_decode($usuario->foto_positions, true) ?? [];
                                    $primeraFoto = is_array($fotos) && !empty($fotos) ? $fotos[0] : null;
                                    $posicionFoto = in_array(($positions[$primeraFoto] ?? ''), ['left', 'right', 'center']) ? $positions[$primeraFoto] : 'center';

                                    $currentDay = strtolower($now->locale('es')->dayName);
                                    $isAvailable = false;
                                    foreach ($usuario->disponibilidad as $disponibilidad) {
                                        if (strtolower($disponibilidad->dia) === $currentDay) {
                                            if ($disponibilidad->hora_desde === '00:00:00' && $disponibilidad->hora_hasta === '23:59:00') {
                                                $isAvailable = true;
                                                break;
                                            }

                                            $horaDesde = Carbon\Carbon::parse($disponibilidad->hora_desde);
                                            $horaHasta = Carbon\Carbon::parse($disponibilidad->hora_hasta);

                                            if ($horaHasta->lessThan($horaDesde)) {
                                                if ($now->greaterThanOrEqualTo($horaDesde) || $now->lessThanOrEqualTo($horaHasta)) {
                                                    $isAvailable = true;
                                                    break;
                                                }
                                            } else {
                                                if ($now->between($horaDesde, $horaHasta)) {
                                                    $isAvailable = true;
                                                    break;
                                                }
                                            }
                                        }
                                    }

                                    $mostrarPuntoVerde = ($usuario->estadop == 1 || $usuario->estadop == 3) && $isAvailable;
                                    
                                    if ($usuarioDestacado) {
                                        $fotosDestacado = json_decode($usuarioDestacado->fotos, true);
                                        $positionsDestacado = json_decode($usuarioDestacado->foto_positions, true) ?? [];
                                        $descripcionFotosDestacado = json_decode($usuarioDestacado->descripcion_fotos, true) ?? [];
                                        $primeraFotoDestacado = is_array($fotosDestacado) && !empty($fotosDestacado) ? $fotosDestacado[0] : null;
                                        $posicionFotoDestacado = in_array(($positionsDestacado[$primeraFotoDestacado] ?? ''), ['left', 'right', 'center']) ? $positionsDestacado[$primeraFotoDestacado] : 'center';
                                        $descripcionFotoDestacado = $descripcionFotosDestacado[$primeraFotoDestacado] ?? 'Foto de ' . $usuarioDestacado->fantasia;
                                    }
                                    $url = $usuario->fantasia;
                                    
                                    if(preg_match('/^[a-z áéíóúñüÁÉÍÓÚÑÜ]*$/',utf8_encode($url))){
                                       
                                    }else{
                                        
                                        $url = str_replace(' ', '-', $url);
                                        $url = str_replace('ñ', 'n', $url);
                                        $url = str_replace('Ñ', 'n', $url);
                                        $url = str_replace('á', 'a', $url);
                                        $url = str_replace('é', 'e', $url);
                                        $url = str_replace('í', 'i', $url);
                                        $url = str_replace('ó', 'o', $url);
                                        $url = str_replace('ú', 'u', $url);
                                        $url = str_replace('ü', 'u', $url);
                                        $url = str_replace('Á', 'a', $url);
                                        $url = str_replace('É', 'e', $url);
                                        $url = str_replace('Í', 'i', $url);
                                        $url = str_replace('Ó', 'o', $url);
                                        $url = str_replace('Ú', 'u', $url);
                                        $url = str_replace('Ü', 'u', $url);
                                    }

                                    $descripcionFotos = json_decode($usuario->descripcion_fotos, true) ?? [];
                                @endphp

                                <a href="{{ route('perfil.show', ['nombre' => strtolower($url) . '-' . $usuario->id]) }}" class="inicio-card">
                                    <div class="inicio-card-category">{{ strtoupper(str_replace('_', ' ', $usuario->categorias)) }}</div>
                                    <div class="inicio-card-image">
                                        <div class="inicio-image">
                                            <img src="{{ $primeraFoto ? asset("storage/chicas/{$usuario->id}/{$primeraFoto}") : asset("images/default-avatar.png") }}" loading="lazy" alt="{{ $descripcionFotos[$primeraFoto] ?? 'Foto de ' . $usuario->fantasia }}" title="{{ 'Escort ' .$usuario->fantasia }}">
                                        </div>
                                        <div class="inicio-card-overlay">
                                            <div class="box-inicio-card">
                                                <h3 class="inicio-card-title">
                                                    {{ $usuario->fantasia }}
                                                    @if($mostrarPuntoVerde)
                                                        <span class="online-dot"></span>
                                                    @endif
                                                </h3>
                                                <span class="inicio-card-age">{{ $usuario->edad }}</span>
                                            </div>
                                            <div class="inicio-card-location">
                                                <img src="{{ asset('images/location.svg') }}" loading="lazy" alt="location-icon" class="location-icon2">
                                                @if($ciudadSeleccionada->url === 'santiago')
                                                @if($usuario->sector)
                                                {{ $usuario->sector->nombre }}
                                                @else
                                                {{ $ubicacionesMostradas[$usuario->id] ?? 'Sector no disponible' }}
                                                @endif
                                                @else
                                                {{ $usuario->ubicacion }}
                                                @endif
                                                <span class="inicio-card-price">
                                                    {{ $usuario->precio > 0 ? '$' . number_format($usuario->precio, 0, ',', '.') : 'Consultar' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </section>            
            {{-- aquiii --}}  
            
            @if($usuarioDestacado)
                    @php
                        $fotosDestacado = json_decode($usuarioDestacado->fotos, true);
                        $positionsDestacado = json_decode($usuarioDestacado->foto_positions, true) ?? [];
                        $primeraFotoDestacado = is_array($fotosDestacado) && !empty($fotosDestacado) ? $fotosDestacado[0] : null;
                        $posicionFotoDestacado = in_array(($positionsDestacado[$primeraFotoDestacado] ?? ''), ['left', 'right', 'center']) ? $positionsDestacado[$primeraFotoDestacado] : 'center';

                        // Lógica de disponibilidad para usuario destacado
                        $isAvailableDestacado = false;
                        foreach ($usuarioDestacado->disponibilidad as $disponibilidad) {
                            if (strtolower($disponibilidad->dia) === $currentDay) {
                                // Check for full time availability
                                if (trim($disponibilidad->hora_desde) === '00:00:00' && trim($disponibilidad->hora_hasta) === '23:59:00') {
                                    $isAvailableDestacado = true;
                                    break;
                                }

                                // Regular time slot check
                                $horaDesde = Carbon\Carbon::parse($disponibilidad->hora_desde);
                                $horaHasta = Carbon\Carbon::parse($disponibilidad->hora_hasta);

                                if ($horaHasta->lessThan($horaDesde)) {
                                    if ($now->greaterThanOrEqualTo($horaDesde) || $now->lessThanOrEqualTo($horaHasta)) {
                                        $isAvailableDestacado = true;
                                        break;
                                    }
                                } else {
                                    if ($now->between($horaDesde, $horaHasta)) {
                                        $isAvailableDestacado = true;
                                        break;
                                    }
                                }
                            }
                        }

                        $mostrarPuntoVerdeDestacado = ($usuarioDestacado->estadop == 1 || $usuarioDestacado->estadop == 3) && $isAvailableDestacado;
                        
                    @endphp
                    
                    <div class="col-md-2">
                        <a href="{{ route('perfil.show', ['nombre' => strtolower(eliminar_acentos(($usuarioDestacado->fantasia))) . '-' . $usuarioDestacado->id]) }}" class="inicio-featured-card">
                            <div class="inicio-featured-label">CHICA DEL MES</div>
                            <div class="inicio-featured-image"
                                style="background-image: url('{{ $primeraFotoDestacado ? asset("storage/chicas/{$usuarioDestacado->id}/{$primeraFotoDestacado}") : asset("images/default-avatar.png") }}');
                        background-position: {{ $posicionFotoDestacado }} center;">
                            <img src="{{ $primeraFotoDestacado ? asset("storage/chicas/{$usuarioDestacado->id}/{$primeraFotoDestacado}") : asset("images/default-avatar.png") }}"
                            alt="{{ isset($descripcionFotoDestacado) ? $descripcionFotoDestacado : 'Foto de escort' }}" loading="lazy"
                                style="visibility: hidden; height: 0;">
                                    
                                <div class="inicio-featured-overlay">
                                    <div class="box-inicio-featured">
                                        <h3 class="inicio-featured-title">
                                            {{ $usuarioDestacado->fantasia }}
                                            @if($mostrarPuntoVerdeDestacado)
                                                <span class="online-dot"></span>
                                            @endif                            
                                        </h3>
                                        <span class="inicio-featured-age">{{ $usuarioDestacado->edad }}</span>
                                    </div>
                                    <div class="location-price">
                                        <span class="inicio-featured-location">
                                            <img src="{{ asset('images/location.svg') }}" alt="location-icon" class="location-icon2" loading="lazy" aria-hidden="true"></i>
                                            @if($ciudadSeleccionada->url === 'santiago')
                                            @if($usuarioDestacado->sector)
                                            {{ $usuarioDestacado->sector->nombre }}
                                            @else
                                            {{ $ubicacionesMostradas[$usuarioDestacado->id] ?? 'Sector no disponible' }}
                                            @endif
                                            @else
                                            {{ $usuarioDestacado->ubicacion }}
                                            @endif
                                        </span>
                                        <span class="inicio-featured-price">
                                            {{ $usuarioDestacado->precio ? '$' . number_format($usuarioDestacado->precio, 0, ',', '.') : 'Consultar' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                <aside class="online-panel">
                    <h2 class="online-panel-title">Chicas online</h2>
                    <div class="online-count">
                        {{ $totalOnline }} Disponibles
                    </div>
                    <div class="online-container">
                        <ul class="online-list">
                             
                            @foreach($usuariosOnline as $usuario)
                            @php
                                $fotos = json_decode($usuario->fotos, true);
                                $positions = json_decode($usuario->foto_positions, true) ?? [];
                                $primeraFoto = is_array($fotos) && !empty($fotos) ? $fotos[0] : null;
                                $posicionFoto = in_array(($positions[$primeraFoto] ?? ''), ['left', 'right', 'center']) ? $positions[$primeraFoto] : 'center';
                            
                                
                            @endphp
                            
                            <li class="online-item-enlaces">
                                <img src="{{ $primeraFoto ? asset('storage/chicas/' . $usuario->id . '/' . $primeraFoto) : asset('images/default-avatar.png') }}"
                                    alt="{{ $usuario->fantasia }}"
                                    class="online-image"
                                    style="object-position: {{ $posicionFoto }} center;"
                                    loading="lazy">
                                <div class="online-info">
                                    <div class="online-name">
                                        {{ $usuario->fantasia }}
                                        <span class="online-age">{{ $usuario->edad }}</span>
                                    </div>
                                    <div class="online-status">ONLINE</div>
                                    <a href="{{ route('perfil.show', ['nombre' => strtolower(eliminar_acentos($usuario->fantasia)). '-' . $usuario->id]) }}" class="online-profile-button">Ver perfil</a>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>    
                    
            @if(!$usuarios->isEmpty())
                <div class="pagination-container">
                    {{ $usuarios->links('layouts.pagination') }}
                </div>
            @endif
        </div>


        <div class="sections-container">
            <!-- Volvieron Section -->
            <section class="volvieronyprimera-section">
                <div class="swiper-container">
                    <div class="category-header">
                        <h2>Escorts de Regreso</h2>
                    </div>
                    <div class="swiper-wrapper1" style="display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 0.5rem;">
                        @foreach($volvieron as $usuario)
                        @php
                        $now = now();

                        $fotos = json_decode($usuario->fotos, true);
                        $positions = json_decode($usuario->foto_positions, true) ?? [];
                        $primeraFoto = is_array($fotos) && !empty($fotos) ? $fotos[0] : null;
                        $posicionFoto = in_array(($positions[$primeraFoto] ?? ''), ['left', 'right', 'center']) ?
                        $positions[$primeraFoto] : 'center';

                        $isAvailable = false;
                        if ($usuario->disponibilidad) {
                        foreach ($usuario->disponibilidad as $disponibilidad) {
                        if (strtolower($disponibilidad->dia) === $currentDay) {
                        $horaDesde = Carbon\Carbon::parse($disponibilidad->hora_desde);
                        $horaHasta = Carbon\Carbon::parse($disponibilidad->hora_hasta);

                        if ($horaHasta->lessThan($horaDesde)) {
                        if ($now->greaterThanOrEqualTo($horaDesde) || $now->lessThanOrEqualTo($horaHasta)) {
                        $isAvailable = true;
                        break;
                        }
                        } else {
                        if ($now->between($horaDesde, $horaHasta)) {
                        $isAvailable = true;
                        break;
                        }
                        }
                        }
                        }
                        }

                        $mostrarPuntoVerde = ($usuario->estadop == 1 || $usuario->estadop == 3) && $isAvailable;
                        
                        
                        @endphp
                        <a href="{{ route('perfil.show', ['nombre' => strtolower(eliminar_acentos($usuario->fantasia)) . '-' . $usuario->id]) }}" class="swiper-slide2" style="flex: 0 0 auto; margin-right: 0;">
                            <div class="volvieronyprimera-card">
                                <div class="watermark-container">
                                    <div class="watermark"></div>
                                </div>

                                <div class="volvieronyprimera-vip-tag">{{ strtoupper(str_replace('_', ' ', $usuario->categorias)) }}</div>
                                @php
                                $fotos = json_decode($usuario->fotos, true);
                                $primeraFoto = is_array($fotos) && !empty($fotos) ? $fotos[0] : null;
                                $descripcionFotos = json_decode($usuario->descripcion_fotos, true) ?? [];
        $primeraFoto = is_array($fotos) && !empty($fotos) ? $fotos[0] : null;

        $descripcionFoto = $descripcionFotos[$primeraFoto] ?? 'Foto de ' . $usuario->fantasia;
                                
                                @endphp
                                <img class="volvieronyprimera-image"
                                    src="{{ $primeraFoto ? (file_exists(storage_path('app/public/chicas/' . $usuario->id . '/thumb_' . $primeraFoto)) ? 
        asset('storage/chicas/' . $usuario->id . '/thumb_' . $primeraFoto) : 
        asset('storage/chicas/' . $usuario->id . '/' . $primeraFoto)) : 
        asset('images/default-avatar.png') }}" alt="{{ $descripcionFoto }}" loading="lazy"
                                    />
                                <div class="volvieronyprimera-content">
                                    <div class="volvieronyprimera-user-info">
                                        <div class="volvieronyprimera-user-main">
                                            <h3 style="display: flex; align-items: center; gap: 0.5rem;">
                                                {{ $usuario->fantasia }}
                                                @if($mostrarPuntoVerde)
                                                    <span class="online-dot1"></span>
                                                @endif
                                            </h3>
                                            <span class="volvieronyprimera-age">{{ $usuario->edad }}</span>
                                        </div>
                                        <div class="volvieronyprimera-location-price">
                                            <div class="location-container">
                                                <img src="{{ asset('images/location.svg') }}" alt="location-icon" class="location-icon2" loading="lazy">
                                                <span class="volvieronyprimera-location">
                                                @if($ciudadSeleccionada->url === 'santiago')
        @if($usuario->sector)
            {{ $usuario->sector->nombre }}
        @else
            {{ $ubicacionesMostradas[$usuario->id] ?? 'Sector no disponible' }}
        @endif
    @else
        {{ $usuario->ubicacion }}
    @endif
                                                </span>
                                            </div>
                                            <span class="volvieronyprimera-price">{{ $usuario->precio > 0 ? '$' . number_format($usuario->precio, 0, ',', '.') : 'Consultar' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="swiper-pagination2"></div>
                </div>
            </section>

            <!-- Primera vez Section -->
            <section class="volvieronyprimera-section">
                <div class="swiper-container">
                    <div class="category-header">
                        <h2>Escorts Nuevas</h2>
                    </div>
                    <div class="swiper-wrapper1" style="display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 0.5rem;">
                        @foreach($primeraVez as $usuario)
                        @php
                        $now = now();

                        $fotos = json_decode($usuario->fotos, true);
                        $positions = json_decode($usuario->foto_positions, true) ?? [];
                        $primeraFoto = is_array($fotos) && !empty($fotos) ? $fotos[0] : null;
                        $posicionFoto = in_array(($positions[$primeraFoto] ?? ''), ['left', 'right', 'center']) ?
                        $positions[$primeraFoto] : 'center';

                        $isAvailable = false;
                        if ($usuario->disponibilidad) {
                        foreach ($usuario->disponibilidad as $disponibilidad) {
                        if (strtolower($disponibilidad->dia) === $currentDay) {
                        $horaDesde = Carbon\Carbon::parse($disponibilidad->hora_desde);
                        $horaHasta = Carbon\Carbon::parse($disponibilidad->hora_hasta);

                        if ($horaHasta->lessThan($horaDesde)) {
                        if ($now->greaterThanOrEqualTo($horaDesde) || $now->lessThanOrEqualTo($horaHasta)) {
                        $isAvailable = true;
                        break;
                        }
                        } else {
                        if ($now->between($horaDesde, $horaHasta)) {
                        $isAvailable = true;
                        break;
                        }
                        }
                        }
                        }
                        }

                        $mostrarPuntoVerde = ($usuario->estadop == 1 || $usuario->estadop == 3) && $isAvailable;
                        $descripcionFotos = json_decode($usuario->descripcion_fotos, true) ?? [];
                        $primeraFoto = is_array($fotos) && !empty($fotos) ? $fotos[0] : null;

                        $descripcionFoto = $descripcionFotos[$primeraFoto] ?? 'Foto de ' . $usuario->fantasia;
                        
                        @endphp
                        <a href="{{ route('perfil.show', ['nombre' => strtolower(eliminar_acentos($usuario->fantasia)) . '-' . $usuario->id]) }}" class="swiper-slide2" style="flex: 0 0 auto; margin-right: 0;">
                            <div class="volvieronyprimera-card">
                                <div class="watermark-container">
                                    <div class="watermark"></div>
                                </div>
                                <div class="volvieronyprimera-vip-tag">{{ strtoupper(str_replace('_', ' ', $usuario->categorias)) }}</div>
                                @php
                                $fotos = json_decode($usuario->fotos, true);
                                $primeraFoto = is_array($fotos) && !empty($fotos) ? $fotos[0] : null;
                                @endphp
                                <img class="volvieronyprimera-image"
                                    src="{{ $primeraFoto ? (file_exists(storage_path('app/public/chicas/' . $usuario->id . '/thumb_' . $primeraFoto)) ? 
        asset('storage/chicas/' . $usuario->id . '/thumb_' . $primeraFoto) : 
        asset('storage/chicas/' . $usuario->id . '/' . $primeraFoto)) : 
        asset('images/default-avatar.png') }}"alt="{{ $descripcionFoto }}" loading="lazy"
                                    />
                                <div class="volvieronyprimera-content">
                                    <div class="volvieronyprimera-user-info">
                                        <div class="volvieronyprimera-user-main">
                                            <h3 style="display: flex; align-items: center; gap: 0.5rem;">
                                                {{ $usuario->fantasia }}
                                                @if($mostrarPuntoVerde)
                                                <span class="online-dot1"></span>
                                                @endif
                                            </h3>
                                            <span class="volvieronyprimera-age">{{ $usuario->edad }}</span>
                                        </div>
                                        <div class="volvieronyprimera-location-price">
                                            <div class="location-container">
                                                <img src="{{ asset('images/location.svg') }}" alt="location-icon" class="location-icon2" loading="lazy">
                                                <span class="volvieronyprimera-location">
                                                    @if($ciudadSeleccionada->url === 'santiago')
                                                    {{ $ubicacionesMostradas[$usuario->id] ?? 'Sector no disponible' }}
                                                    @else
                                                    {{ $usuario->ubicacion }}
                                                    @endif
                                                </span>
                                            </div>
                                            <span class="volvieronyprimera-price">{{ $usuario->precio > 0 ? '$' . number_format($usuario->precio, 0, ',', '.') : 'Consultar' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="swiper-pagination2"></div>
                </div>


            </section>

            <!-- Últimas experiencias Section -->
            <section class="UEInicio">
                <div class="swiper-container2">
                    <div class="category-header">
                        <h2>Últimas experiencias</h2>
                    </div>
                    <div class="UEInicio-grid">
                        @foreach($experiencias as $experiencia)
                            @php
                                $fotos = json_decode($experiencia->fotos);
                                $pathImage = (count($fotos)) ? asset('storage/chicas/' . $experiencia->chica_id . '/' . $fotos[0]) : asset('storage/profile_photos/default-avatar.jpg');
                            @endphp

                            <a href="{{ route('post.show', ['id_blog' => $experiencia->id_blog, 'id' => $experiencia->id]) }}" class="UEInicio-card">
                                <div class="UEInicio-image-container">
                                    <img src="{{ $pathImage }}" alt="{{ $experiencia->titulo }}" class="UEInicio-image" loading="lazy">
                                    
                                </div>
                                <div class="UEInicio-content">
                                    <span class="UEInicio-date">
                                        {{ \Carbon\Carbon::parse($experiencia->created_at)->format('d F, Y') }}
                                    </span>
                                    <h3 class="UEInicio-title">{{ $experiencia->titulo }}</h3>
                                    <span class="UEInicio-author">{{ $experiencia->autor_nombre }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="swiper-pagination2"></div>
                </div>
            </section>

            <!-- Blog Section -->
            <section class="BlogInicio">
                <div class="swiper-blog">
                    <div class="category-header">
                    <h2>Blog 
                    @if(isset($ciudadSeleccionada))
                        <span class="ciudad-title">de {{ $ciudadSeleccionada->nombre }}</span>
                        
                    @endif
                    
                </h2>
                    </div>
                    @php
                        $enlace_actual2 = request()->path();
                        $ruta = explode("/", $enlace_actual2);
                        $enlace_actual2 = $ruta[0];
                        $coincidencia = false;
                    @endphp

                    {{-- Mostrar artículos cuyo tag coincide con la URL --}}
                    @foreach($tags as $tagsarticle)
                        @if($enlace_actual2 == $tagsarticle->slug)
                            @php $coincidencia = true; @endphp

                            <div class="BlogInicio-grid swiper-wrapper">
                                @foreach($articulos as $article)
                                    @foreach($article->tags as $tag)
                                        @if($tag->id == $tagsarticle->id)
                                            <div class="BlogInicio-item swiper-slide">
                                                <a href="{{ route('blog.show_article', $article->slug) }}" class="BlogInicio-card">
                                                    <div class="BlogInicio-image-container">
                                                        <img src="{{ $article->imagen ? asset('storage/' . $article->imagen) : asset('images/default-blog.png') }}"
                                                            alt="{{ $article->titulo }}"
                                                            class="BlogInicio-image"
                                                            loading="lazy">
                                                        @if($article->destacado)
                                                            <div class="BlogInicio-destacado">Destacado</div>
                                                        @endif
                                                    </div>
                                                    <div class="BlogInicio-content">
                                                        <span class="BlogInicio-date">
                                                            {{ $article->fecha_publicacion ? \Carbon\Carbon::parse($article->fecha_publicacion)->format('d F, Y') : '' }}
                                                        </span>
                                                        <h3 class="BlogInicio-title">{{ $article->titulo }}</h3>
                                                       
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                    @endforeach

                    {{-- Si hubo coincidencia, no mostrar artículos con el tag "general" --}}

{{-- Si NO hubo coincidencia, mostrar artículos con el tag "general" --}}
@if(!$coincidencia)
    <div class="BlogInicio-grid swiper-wrapper">
        @foreach($articulos as $article)
            @foreach($article->tags as $tag)
                @if($tag->slug == 'general')
                    <div class="BlogInicio-item swiper-slide">
                        <a href="{{ route('blog.show_article', $article->slug) }}" class="BlogInicio-card">
                            <div class="BlogInicio-image-container">
                                <img src="{{ $article->imagen ? asset('storage/' . $article->imagen) : asset('images/default-blog.png') }}"
                                     alt="{{ $article->titulo }}"
                                     class="BlogInicio-image"
                                     loading="lazy">
                                @if($article->destacado)
                                    <div class="BlogInicio-destacado">Destacado</div>
                                @endif
                            </div>
                            <div class="BlogInicio-content">
                                <span class="BlogInicio-date">
                                    {{ $article->fecha_publicacion ? \Carbon\Carbon::parse($article->fecha_publicacion)->format('d F, Y') : '' }}
                                </span>
                                <h3 class="BlogInicio-title">{{ $article->titulo }}</h3>
                                
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        @endforeach
    </div>
@endif


                    <!-- Solo mostrar en móvil -->
                    <div class="swiper-pagination mobile-only"></div>
                    <div class="swiper-button-next mobile-only"></div>
                    <div class="swiper-button-prev mobile-only"></div>
                </div>
            </section>
        </main>
        
        <div class="container">
            @if(isset($meta->meta_title2) && isset($meta->meta_description2))
                <div class="seo-section">
                    <h2 class="seo-title">
                        {{ strip_tags(html_entity_decode($meta->meta_title2)) }}
                    </h2>
                    <div class="seo-description">{!! $meta->meta_description2 !!}</div>
                </div>
            @endif
        </div>

@endsection