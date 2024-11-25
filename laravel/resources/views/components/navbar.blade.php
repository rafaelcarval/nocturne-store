<nav class="navbar navbar-expand-lg bg-white py-3 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        {{-- Ícones à Esquerda --}}
        <div class="d-flex align-items-center position-relative">
            {{-- Ícone de Usuário --}}
            <a href="#" class="me-3 text-dark">
                <i class="fa-solid fa-user fa-2x"></i> {{-- Aumentado para fa-2x --}}
            </a>

            {{-- Ícone de Carrinho --}}
            <a href="{{ route('cart.index') }}" class="text-dark position-relative">
                <i class="fa-solid fa-cart-shopping fa-2x"></i> {{-- Aumentado para fa-2x --}}
                {{-- Badge do Carrinho --}}
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                        style="transform: translate(-50%, -50%); font-size: 0.8rem; padding: 5px 8px;">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>
        </div>

        {{-- Logo Centralizada --}}
        <div class="text-center">
            <a href="/" class="text-decoration-none">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Nocturne" class="logo mx-auto">
            </a>
        </div>

        {{-- Ícones à Direita --}}
        <div class="d-flex align-items-center">
            {{-- Ícone de menu que ativa o offcanvas --}}
            <button class="btn text-dark me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                <i class="fa-solid fa-bars fa-lg"></i>
            </button>
        </div>
    </div>
</nav>

{{-- Offcanvas Menu --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#store">Loja</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#thrift-store">Brejó (Thrift Store)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#about-us">Sobre Nós</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#contact">Contato</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#returns">Trocas e Devoluções</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#shipping">Envio e Pagamento</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#terms">Termos de Uso</a>
            </li>
        </ul>
    </div>
</div>

<script>
    document.addEventListener('click', function (event) {
        const offcanvas = document.querySelector('.offcanvas.show'); // Menu aberto
        if (offcanvas && !offcanvas.contains(event.target)) {
            const closeButton = document.querySelector('[data-bs-dismiss="offcanvas"]');
            closeButton.click(); // Simula o clique no botão de fechar
        }
    });
</script>
