@extends('layouts.app')

@section('content')
<div class="container my-5 container_my-5_alt_margin">

    {{-- Breadcrumbs --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thrift Store</li>
        </ol>
    </nav>

    {{-- Barra de busca --}}
    <form method="GET" action="{{ route('thrift_store.index') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar produtos..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <div class="row">
        {{-- Menu de categorias --}}
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="sticky-menu">
                <h5 class="mb-3">Categorias</h5>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ route('thrift_store.index') }}" class="{{ request('category') ? '' : 'fw-bold text-primary' }}">Todas</a>
                    </li>
                    @foreach ($categories as $category)
                        <li class="list-group-item">
                            <a href="{{ route('thrift_store.index', ['category' => $category->id]) }}" 
                               class="{{ request('category') == $category->id ? 'fw-bold text-primary' : '' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Listagem de produtos --}}
        <div class="col-md-9">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset($product->images->first()->image_path ?? 'images/default-product.jpg') }}" 
                             class="card-img-top card-image" 
                             alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text fw-bold">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                            <div class="d-flex justify-content-around mt-3">
                                <button class="btn btn-light btn-icon">
                                    <i class="fa-solid fa-cart-plus"></i> <!-- Ícone de adicionar ao carrinho -->
                                </button>
                                <a href="{{ route('thrift_store.show', $product->id) }}" class="btn btn-light btn-icon">
                                    <i class="fa-solid fa-eye"></i> <!-- Ícone de ver detalhes -->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Paginação --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
