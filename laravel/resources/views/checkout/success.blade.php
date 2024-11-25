@extends('layouts.app')

@section('content')
<div class="container my-5 text-center">
    <h2>Compra Finalizada com Sucesso!</h2>
    @if (session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <a href="{{ route('store.index') }}" class="btn btn-primary mt-4">Voltar à Loja</a>
</div>
@endsection
