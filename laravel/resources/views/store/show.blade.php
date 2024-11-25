@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        {{-- Imagens do produto --}}
        <div class="col-md-6 position-relative">
            {{-- Imagem principal --}}
            <div class="main-image-container position-relative mb-3">
                <img src="{{ asset($product->images->first()->image_path ?? 'images/default-product.jpg') }}" 
                    class="img-fluid main-image" 
                    id="mainImage" 
                    alt="{{ $product->name }}">

                {{-- Zoom flutuante --}}
                <div id="zoomLens" class="zoom"></div>
            </div>

            {{-- Miniaturas --}}
            <div class="thumb-container d-flex flex-wrap">
                @foreach ($product->images as $image)
                    <div class="thumb me-2">
                        <img src="{{ asset($image->image_path) }}" 
                             class="img-thumbnail thumb-image" 
                             data-large="{{ asset($image->image_path) }}">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Detalhes do produto --}}
        <div class="col-md-6">
            <h1 class="display-5">{{ $product->name }}</h1>
            <p class="text-muted">{{ $product->category->name }}</p>
            <p class="lead">{{ $product->description }}</p>
            <p class="fw-bold fs-4">R$ {{ number_format($product->price, 2, ',', '.') }}</p>

            {{-- Seleção de tamanhos --}}
            <div class="mb-3">
                <label for="sizeSelect" class="form-label">Selecione o tamanho:</label>
                <select class="form-select" id="sizeSelect" name="size">
                    <option selected disabled>Escolha um tamanho</option>
                    @foreach ($product->sizes_array as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Botões --}}
            <form action="#" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary me-3">
                    <i class="fa-solid fa-cart-plus"></i> Adicionar ao Carrinho
                </button>
                <a href="{{ route('store.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Voltar à Loja
                </a>
            </form>
        </div>
    </div>
</div>

@endsection

