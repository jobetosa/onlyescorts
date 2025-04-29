<div class="mobile-nav">
    <!-- Menú desplegable -->
    <div id="menuOverlay">
        <div class="menu-content">
            <button id="closeMenu">✕</button>

            <div class="menu-logo">
                <img src="{{ asset('images/logo_XL-2.png') }}" alt="Logo OnlyEscorts">
            </div>

            <div class="menu-links">
                <div class="dropdown">
                    <button class="dropdown-button menu-link">Ciudades</button>
                    <div class="dropdown-content py-4 py-md-0">
                        @php
                            $ciudadesPorZona = $ciudades->groupBy('zona');
                            $ordenZonas = ['Zona Norte', 'Zona Centro', 'Zona Sur'];
                        @endphp

                        @foreach($ordenZonas as $zona)
                            @if(isset($ciudadesPorZona[$zona]))
                                <div class="dropdown-column">
                                    <p>{{ $zona }}</p>
                                    @if($zona == 'Zona Sur')
                                        <div class="row">
                                            @foreach($ciudadesPorZona[$zona] as $ciudad)
                                                <div class="col-6">
                                                    <a href="/escorts-{{ $ciudad->url }}" class="ciudad-link text-capitalize">
                                                        {{ $ciudad->nombre }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        @foreach($ciudadesPorZona[$zona] as $ciudad)
                                            <a href="/escorts-{{ $ciudad->url }}" class="ciudad-link text-capitalize">
                                                {{ $ciudad->nombre }}
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('favoritos.show') }}" class="menu-link">Favoritos</a>
                <a href="{{ route('blog') }}" class="menu-link">Blog</a>
                <a href="{{ route('foro') }}" class="menu-link">Foro Escorts</a>
                
                @if(Auth::check())
                    @if(Auth::user()->rol === '1')
                        <a href="{{ route('admin.profile') }}" class="menu-link">{{ Auth::user()->name }}</a>
                    @elseif(Auth::user()->rol === '2')
                        <a href="{{ route('admin.profile') }}" class="menu-link">{{ Auth::user()->name }}</a>
                    @else
                        <a href="{{ route('admin.profile') }}" class="menu-link">{{ Auth::user()->name }}</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button class="menu-link btn-logout mx-auto">SALIR</button>
                    </form>
                @else
                    <div class="d-inline-flex justify-content-center align-items-center box-auth-items">
                        <a href="{{ route('login') }}" class="menu-link">Acceder</a>
                        <div class="separator"></div>
                        <a href="{{ route('register') }}" class="menu-link">Registrarse</a>
                    </div>                                        
                @endif
                
                <a href="{{ route('publicate.form') }}" class="menu-link custom mt-5">Publícate</a>
            </div>
        </div>
    </div>

    <!-- Barra de navegación inferior -->
    <nav class="mobile-bottom-nav">
        <div class="nav-items">
            <a href="{{ route('home') }}" class="nav-item">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z" />
                </svg>
                <span class="nav-text">Inicio</span>
            </a>

            <a href="#" class="nav-item" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-search"></i>
                <span class="nav-text">Filtro avanzado</span>
            </a>

            <a href="{{ route('favoritos.show') }}" class="nav-item">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                </svg>
                <span class="nav-text">Favoritos</span>
            </a>

            <button id="menuButton" class="nav-item">
                <svg class="nav-icon" viewBox="0 0 24 24">
                    <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z" />
                </svg>
                <span class="nav-text">Menú</span>
            </button>
        </div>
    </nav>

    @if(Route::currentRouteName() == 'perfil.show')
        <!-- Botón WhatsApp exclusivo para móviles -->
        <a href="https://api.whatsapp.com/send?phone={{ isset($usuarioPublicate) ? $usuarioPublicate->telefono : '0000000000' }}&text=Hola%20{{ isset($usuarioPublicate) ? $usuarioPublicate->fantasia : 'usuario' }}!%20Vi%20tu%20anuncio%20en%20OnlyEscorts%20y%20me%20gustar%C3%ADa%20saber%20m%C3%A1s%20sobre%20tus%20servicios." 
        class="escortperfil-btn-movil disponible" target="_blank">
            <i class="fab fa-whatsapp"></i> WHATSAPP
        </a>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('menuButton');
            const menuOverlay = document.getElementById('menuOverlay');
            const closeMenu = document.getElementById('closeMenu');

            menuButton.addEventListener('click', () => {
                menuOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            closeMenu.addEventListener('click', () => {
                menuOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            });

            menuOverlay.addEventListener('click', (e) => {
                if (e.target === menuOverlay) {
                    menuOverlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        });

        document.querySelector('.dropdown-button').addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('active');

            // Mostrar u ocultar el contenido del dropdown
            const dropdownContent = this.nextElementSibling;
            
            if (dropdownContent.style.display === 'flex') {
                dropdownContent.style.display = 'none';
            } else {
                dropdownContent.style.display = 'flex';
            }
        });
    </script>
</div>