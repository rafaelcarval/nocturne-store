<footer class="bg-black text-white py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            {{-- Redes Sociais --}}
            <div class="d-flex align-items-center">
                <span class="me-2">in...</span>
                <a href="https://www.instagram.com/noc2k23/" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-whatsapp fa-lg"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-tiktok fa-lg"></i></a>
                <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
            </div>

            {{-- Links do Rodapé --}}
            <div class="d-flex">
                <a href="{{ route('contact') }}" class="text-white text-decoration-none mx-3">Contato</a>
                <a href="{{ route('returns') }}" class="text-white text-decoration-none mx-3">Trocas & Devoluções</a>
                <a href="{{ route('shipping') }}" class="text-white text-decoration-none mx-3">Envio & Pagamento</a>
                <a href="{{ route('terms') }}" class="text-white text-decoration-none mx-3">Termos de Uso</a>
            </div>
        </div>
    </div>
</footer>
