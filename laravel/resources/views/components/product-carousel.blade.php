<div class="my-5">
    <h2 class="text-center">{{ $title }}</h2>
    <div id="{{ $id }}" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach (array_chunk($products->toArray(), 4) as $index => $productChunk)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($productChunk as $product)
                            <div class="col-md-3">
                                <div class="card product-card mx-auto">
                                    <img src="{{ asset($product['image']) }}" 
                                         class="card-img-top carousel-image" 
                                         alt="{{ $product['name'] }}">
                                    <div class="card-body" style="background-image: url('images/street-bg.jpg');">
                                        <h5 class="card-title">{{ $product['name'] }}</h5>
                                        <p class="card-text">{{ $product['description'] }}</p>
                                        <p class="card-text"><strong>R$ {{ number_format($product['price'], 2, ',', '.') }}</strong></p>
                                        <div class="card-buttons d-flex justify-content-around">
                                            <form action="{{ route('cart.add', $product['id']) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-light btn-icon">
                                                    <i class="fa-solid fa-cart-plus"></i>
                                                </button>
                                            </form>
                                            <a href="{{ url('/thrift_store/' . $product['id']) }}" class="btn btn-view-product">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Setas padrão do Bootstrap ajustadas --}}
        <button class="carousel-control-prev custom-control-prev" type="button" data-bs-target="#{{ $id }}" data-bs-slide="prev">
            <i class="fa-solid fa-circle-chevron-left custom-arrow"></i>
        </button>
        <button class="carousel-control-next custom-control-next" type="button" data-bs-target="#{{ $id }}" data-bs-slide="next">
            <i class="fa-solid fa-circle-chevron-right custom-arrow"></i>
        </button>
    </div>
</div>
