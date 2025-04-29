@extends('layouts.app_blog')

@section('title')
    {{ $articulo->titulo }}
@endsection

@section('content')
    <style>

        img {            
            max-width: 100%;
        }

        @media (max-width: 415px) {
            .blog-container {
                flex-direction: column;
            }


        .featured-image img {
            object-fit: contain;
        }
    }
    </style>
    <div class="blog-container">
        {{-- Sección de compartir y tabla de contenidos --}}
        <div class="blog-sidebar">
            <div class="share-section">
                <span>Compartir</span>
                <div class="social-icons">
                    <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(Request::url()) }}&title={{ urlencode($articulo->titulo) }}"
                        target="_blank"
                        class="social-button linkedin">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ urlencode($articulo->titulo) }}"
                        target="_blank"
                        class="social-button twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://github.com/share?url={{ urlencode(Request::url()) }}"
                        target="_blank"
                        class="social-button github">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($articulo->titulo . ' ' . Request::url()) }}"
                        class="social-button email">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <div class="table-contents">
                <h3>TABLA DE CONTENIDOS</h3>
                <div id="contenidos-dinamicos" class="contents-list">
                    <!-- Se llenará dinámicamente con JavaScript -->
                </div>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="blog-content">
            <h1 class="blog-title">{{ $articulo->titulo }}</h1>
            <div class="article-meta">
                <span class="blog-author">Por {{ $articulo->user->name }}</span>
                <span class="blog-date">
                    {{ \Carbon\Carbon::parse($articulo->fecha_publicacion)->format('F d, Y') }}
                </span>
            </div>

            @if($articulo->imagen)
                <div class="featured-image">
                    <img src="{{ asset('storage/' . $articulo->imagen) }}"
                        alt="{{ $articulo->titulo }}"
                        class="rounded-lg shadow-lg">
                </div>
            @endif

            <div class="blog-text">
                {!! $articulo->contenido !!}
            </div>

            <div class="author-section">
                <div class="author-card">
                    <div class="author-avatar">
                        @if($articulo->user->foto)
                        <img src="{{ Storage::url($articulo->user->foto) }}" alt="{{ $articulo->user->name }}">
                        @else
                        <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ $articulo->user->name }}">
                        @endif
                    </div>
                    <div class="author-info">
                        <h3 class="author-title">
                            <span class="author-name">{{ $articulo->user->name }}</span>
                            @if($articulo->user->linkedin)
                            <a href="https://{{ $articulo->user->linkedin }}" target="_blank" class="linkedin-icon">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            @endif
                        </h3>
                        <p class="author-bio">{{ $articulo->user->descripcion ?? 'No hay descripción disponible' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Primero verificamos que existan los elementos necesarios
            const contenido = document.querySelector('.blog-text');
            const contenidosDinamicos = document.getElementById('contenidos-dinamicos');

            // Verificar si los elementos existen antes de continuar
            if (!contenido || !contenidosDinamicos) {
                console.log('No se encontraron los elementos necesarios');
                return;
            }

            // Función para generar un ID único para cada encabezado
            function slugify(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
            }

            // Obtener todos los encabezados h1 y h2 del contenido
            const headings = contenido.querySelectorAll('h1, h2');

            // Verificar si hay encabezados antes de crear la lista
            if (headings.length === 0) {
                contenidosDinamicos.innerHTML = '<p>No hay secciones disponibles</p>';
                return;
            }

            // Generar la tabla de contenidos
            const ul = document.createElement('ul');
            ul.className = 'contents-list';
            
            headings.forEach((heading, index) => {
                // Generar ID único para el encabezado si no tiene uno
                if (!heading.id) {
                    heading.id = `heading-${slugify(heading.textContent)}-${index}`;
                }

                // Crear elemento de la lista
                const li = document.createElement('li');
                const a = document.createElement('a');
                
                // Estilizar según nivel de encabezado
                if (heading.tagName === 'H2') {
                    li.style.paddingLeft = '1rem';
                }

                a.href = `#${heading.id}`;
                a.textContent = heading.textContent;
                a.className = 'table-link';
                
                li.appendChild(a);
                ul.appendChild(li);
            });

            // Limpiar el contenido existente y agregar la nueva lista
            contenidosDinamicos.innerHTML = '';
            contenidosDinamicos.appendChild(ul);

            // Agregar comportamiento de scroll suave
            document.querySelectorAll('.table-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>

@endsection