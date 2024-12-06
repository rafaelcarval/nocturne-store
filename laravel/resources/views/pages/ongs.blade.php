@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">ONGs Parceiras</h1>
    <p>
        Estamos comprometidos em fazer a diferença. Se você representa uma ONG e deseja participar ou receber 
        doações de roupas e outros itens, preencha o formulário abaixo. Queremos contribuir para causas sociais 
        e fortalecer comunidades!
    </p>
    <form action="{{ route('ongs.contact') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome da ONG</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Nome da ONG" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="email@exemplo.com" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Mensagem</label>
            <textarea id="message" name="message" class="form-control" rows="5" placeholder="Explique como podemos ajudar" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    @if (session('success'))
        <div class="alert alert-success mt-4">{{ session('success') }}</div>
    @endif
</div>
@endsection
