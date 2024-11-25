@extends('layouts.app')

@section('content')
<div class="checkout-container">
    <h1 class="checkout-title">Finalizar Compra</h1>

    <div class="checkout-grid">
        {{-- Coluna: Endereço --}}
        <div class="address-section">
            <h2 class="section-title">Endereço de Entrega</h2>
            @if ($address && !empty($address['number']))
                <div class="address-box">
                    <p><strong>Rua:</strong> {{ $address['street'] }}, {{ $address['number'] }}</p>
                    <p><strong>Bairro:</strong> {{ $address['neighborhood'] }}</p>
                    <p><strong>Cidade:</strong> {{ $address['city'] }} - {{ $address['state'] }}</p>
                    <p><strong>CEP:</strong> {{ $address['cep'] }}</p>
                    <button class="btn btn-edit">Alterar Endereço</button>
                </div>
            @else
                {{-- Formulário de Endereço --}}
                <form action="{{ route('checkout.saveAddress') }}" method="POST" class="address-form">
                    @csrf
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" value="{{ $address['cep'] ?? '' }}" required>

                    <label for="street">Rua</label>
                    <input type="text" id="street" name="street" value="{{ $address['street'] ?? '' }}" required>

                    <label for="number">Número</label>
                    <input type="text" id="number" name="number" value="{{ $address['number'] ?? '' }}" required>

                    <label for="neighborhood">Bairro</label>
                    <input type="text" id="neighborhood" name="neighborhood" value="{{ $address['neighborhood'] ?? '' }}" required>

                    <label for="city">Cidade</label>
                    <input type="text" id="city" name="city" value="{{ $address['city'] ?? '' }}" required>

                    <label for="state">Estado</label>
                    <input type="text" id="state" name="state" value="{{ $address['state'] ?? '' }}" required>

                    <button type="submit" class="btn btn-submit">Salvar Endereço</button>
                </form>
            @endif
        </div>

        {{-- Coluna: Resumo do Pedido e Pagamento --}}
        <div class="order-summary">
            <h2 class="section-title">Como irá pagar?</h2>
            {{-- Métodos de Pagamento --}}
            <div class="payment-options">
                <div class="payment-method">
                    <input type="radio" id="payment-pix" name="payment_method" value="pix" checked>
                    <label for="payment-pix">
                        <i class="fa-solid fa-qrcode"></i> PIX
                    </label>
                </div>
                <div class="payment-method">
                    <input type="radio" id="payment-boleto" name="payment_method" value="boleto">
                    <label for="payment-boleto">
                        <i class="fa-solid fa-barcode"></i> Boleto
                    </label>
                </div>
                <div class="payment-method">
                    <input type="radio" id="payment-card" name="payment_method" value="card">
                    <label for="payment-card">
                        <i class="fa-solid fa-credit-card"></i> Cartão de Crédito
                    </label>
                </div>
            </div>

            {{-- Formulário do Cartão --}}
            <form id="card-form" class="card-form" style="display: none;">
                <label for="card-number">Número do Cartão</label>
                <input type="text" id="card-number" name="card_number" placeholder="0000 0000 0000 0000" required>

                <label for="card-holder">Nome do Titular</label>
                <input type="text" id="card-holder" name="card_holder" placeholder="Como no cartão" required>

                <label for="card-expiration">Validade</label>
                <input type="text" id="card-expiration" name="card_expiration" placeholder="MM/AA" required>

                <label for="card-cvv">CVV</label>
                <input type="text" id="card-cvv" name="card_cvv" placeholder="123" required>

            </form>
            {{-- Cupom --}}
            <h2 class="section-title">Cupom de Desconto</h2>
            <div class="coupon-section">
                @if (session('coupon'))
                    <div class="coupon-applied">
                        <p><strong>Cupom Aplicado:</strong> {{ session('coupon')['code'] }}</p>
                        <p><strong>Desconto Aplicado:</strong> R$ {{ number_format($discount, 2, ',', '.') }}</p>
                    </div>
                @else
                    {{-- Formulário para adicionar cupom --}}
                    <form action="{{ route('cart.applyCoupon') }}" method="POST" id="coupon-form">
                        @csrf
                        <div class="coupon-input">
                            <input type="text" id="coupon" name="coupon" placeholder="Digite o código do cupom" required>
                            <button type="submit" class="btn btn-submit">Aplicar</button>
                        </div>
                    </form>
                    @if (session('error'))
                        <p class="coupon-error">{{ session('error') }}</p>
                    @endif
                @endif
            </div>
            <h2 class="section-title">Resumo do Pedido</h2>
            <div class="summary-box">
                @foreach ($cart as $item)
                    <div class="order-item">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="product-image">
                        <div class="order-details">
                            <h3 class="product-name">{{ $item['name'] }}</h3>
                            <p class="product-quantity">Quantidade: {{ $item['quantity'] }}</p>
                            <p class="product-subtotal">Subtotal: R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="total">
                <h3>Total: R$ {{ number_format($total, 2, ',', '.') }}</h3>
            </div>
            <button class="btn btn-submit w-full">Finalizar Compra</button>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const cardForm = document.getElementById('card-form');

    paymentMethods.forEach(method => {
        method.addEventListener('change', function () {
            if (this.value === 'card') {
                cardForm.style.display = 'block';
            } else {
                cardForm.style.display = 'none';
            }
        });
    });
});

</script>