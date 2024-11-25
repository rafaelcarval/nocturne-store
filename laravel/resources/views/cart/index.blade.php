@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4" style="color: #330066;">Carrinho de Compras</h2>
    @if (!empty($cart))
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Subtotal</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart as $id => $item)
                        <tr data-id="{{ $id }}">
                            <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="img-thumbnail me-3" style="width: 80px;">
                                <div>
                                    <p class="mb-1" style="color: #330066;">{{ $item['name'] }}</p>
                                    <small>Tamanho:</small>
                                    <select class="form-select form-select-sm mt-1 size-dropdown" data-id="{{ $id }}">
                                        @if(!empty($item['available_sizes']))
                                            @foreach ($item['available_sizes'] as $size)
                                                <option value="{{ $size }}" {{ $size == $item['size'] ? 'selected' : '' }}>
                                                    {{ $size }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option disabled>Sem tamanhos disponíveis</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-outline-secondary btn-sm me-2 update-quantity" data-id="{{ $id }}" data-action="decrease">-</button>
                                    <input 
                                        type="number" 
                                        name="quantity" 
                                        value="{{ $item['quantity'] }}" 
                                        min="1" 
                                        class="form-control cart-quantity" 
                                        data-id="{{ $id }}" 
                                        style="width: 70px; text-align: center;">
                                    <button class="btn btn-outline-secondary btn-sm ms-2 update-quantity" data-id="{{ $id }}" data-action="increase">+</button>
                                </div>
                            </td>
                            <td>R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                            <td class="subtotal">R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-danger p-0">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @php $total += $item['price'] * $item['quantity']; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Cálculo de Frete e Cupom de Desconto --}}
        <div class="row my-4">
            <div class="col-md-6">
                <form id="freteForm">
                    <label for="frete" class="form-label">Calcule o Frete:</label>
                    <div class="input-group">
                        <input type="text" id="frete" name="frete" class="form-control" placeholder="Digite seu CEP">
                        <button class="btn btn-outline-secondary" type="button" id="calcularFrete">
                            <i class="fa-solid fa-truck"></i> Calcular
                        </button>
                    </div>
                    <small><a href="https://buscacepinter.correios.com.br/app/endereco/index.php" class="text-muted" target="_blank">Não sei meu CEP</a></small>
                </form>
                <p id="freteResultado" class="text-success mt-2" style="display: none;"></p>
            </div>
            <div class="col-md-6">
                <form id="applyCouponForm" action="{{ route('cart.applyCoupon') }}" method="POST">
                    @csrf
                    <label for="cupom" class="form-label">Cupom de Desconto:</label>
                    <div class="input-group">
                        <input type="text" id="cupom" name="coupon" class="form-control" placeholder="Digite o cupom">
                        <button class="btn btn-outline-secondary" type="submit">Usar Cupom</button>
                    </div>
                </form>
                <p id="couponMessage" class="mt-2" style="font-size: 0.9rem; color: #330066;"></p>
            </div>

        </div>

        {{-- Total e Botões --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('store.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Continuar Comprando
            </a>
            <div class="text-end fw-bold" style="color: #330066;">
                Total: <span class="total">{{ number_format(session('cart_total', $total), 2, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg">
                <i class="fa-solid fa-check"></i> Finalizar Compra
            </a>
        </div>
    @else
        <p class="text-center" style="color: #330066;">Seu carrinho está vazio!</p>
        <div class="text-center mt-4">
            <a href="{{ route('store.index') }}" class="btn btn-secondary">
                Continuar Comprando
            </a>
        </div>
    @endif
</div>

{{-- JavaScript para Atualização Automática --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cart-quantity').forEach(input => {
        input.addEventListener('change', function () {
            const id = this.dataset.id;
            const quantity = this.value;
            const row = this.closest('tr');
            const subtotalElement = row.querySelector('.subtotal');

            fetch(`{{ url('cart/update') }}/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id, quantity })
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      const subtotal = data.subtotal.toFixed(2).replace('.', ',');
                      subtotalElement.textContent = `R$ ${subtotal}`;
                      const total = data.total.toFixed(2).replace('.', ',');
                      document.querySelector('.total').textContent = `R$ ${total}`;
                  }
              });
        });
    });

    document.querySelectorAll('.update-quantity').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const action = this.dataset.action;
            const input = document.querySelector(`.cart-quantity[data-id="${id}"]`);
            let quantity = parseInt(input.value);

            if (action === 'increase') {
                quantity += 1;
            } else if (action === 'decrease' && quantity > 1) {
                quantity -= 1;
            }

            input.value = quantity;
            input.dispatchEvent(new Event('change'));
        });
    });
    document.getElementById('calcularFrete').addEventListener('click', function () {
        const cep = document.getElementById('frete').value;

        if (!cep.match(/^\d{5}-?\d{3}$/)) {
            document.getElementById('freteResultado').textContent = 'CEP inválido!';
            document.getElementById('freteResultado').style.display = 'block';
            return;
        }

        // Enviar para o endpoint Laravel
        fetch('/cart/calculate-freight', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ frete: cep })
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('freteResultado').textContent = data.error;
                } else if (data.success) {
                    document.getElementById('freteResultado').textContent = `Frete calculado para ${data.address.city} - ${data.address.state}: R$ ${data.freight.toFixed(2).replace('.', ',')} (estimativa).`;
                }
                document.getElementById('freteResultado').style.display = 'block';
            })
            .catch(() => {
                document.getElementById('freteResultado').textContent = 'Erro ao calcular o frete.';
                document.getElementById('freteResultado').style.display = 'block';
            });
    });

});

document.addEventListener('DOMContentLoaded', function () {
    const couponForm = document.querySelector('#applyCouponForm');
    const couponMessage = document.querySelector('#couponMessage'); // Elemento para exibir mensagens

    if (couponForm && couponMessage) {
        couponForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Atualiza o valor total no DOM
                    const totalElement = document.querySelector('.total');
                    if (totalElement) {
                        // Remove qualquer prefixo "R$" já existente
                        const totalFormatted = `R$ ${parseFloat(data.total).toFixed(2).replace('.', ',')}`;
                        totalElement.textContent = totalFormatted;
                    }

                    // Exibe a mensagem de sucesso
                    couponMessage.style.color = 'green';
                    if (data.discount) {
                        const discountFormatted = `R$ ${parseFloat(data.discount).toFixed(2).replace('.', ',')}`;
                        couponMessage.textContent = `${data.message} Desconto: ${discountFormatted}`;
                    } else {
                        couponMessage.textContent = data.message;
                    }
                } else {
                    // Exibe mensagem de erro
                    couponMessage.style.color = 'red';
                    couponMessage.textContent = data.message || 'Erro ao aplicar o cupom.';
                }
            })
            .catch(error => {
                console.error('Erro ao aplicar o cupom:', error);
                couponMessage.style.color = 'red';
                couponMessage.textContent = 'Ocorreu um erro ao tentar aplicar o cupom.';
            });

        });
    }
});




</script>

@endsection
