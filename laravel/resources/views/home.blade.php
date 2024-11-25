@extends('layouts.app')

@section('content')
    {{-- Parte grande com Store e Thrift Store --}}
    <x-store-banner />

    {{-- Carrossel de produtos da loja --}}
    <x-product-carousel 
        title="Principais Produtos Store" 
        id="storeCarousel" 
        :products="$storeProducts"
    />

    {{-- Carrossel de produtos do brechó --}}
    <x-product-carousel 
        title="Principais Produtos Thrift Store" 
        id="thriftCarousel" 
        :products="$thriftProducts"
    />

    {{-- Banner sobre nós --}}
    <x-about-banner />
@endsection
