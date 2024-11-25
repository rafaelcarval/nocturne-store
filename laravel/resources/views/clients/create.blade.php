@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h4 class="mb-4">DADOS PESSOAIS</h4>

    {{-- Exibição de mensagem de sucesso --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Exibição de erros globais --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulário --}}
    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- Nome e Sobrenome --}}
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">NOME</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Digite seu nome" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="surname" class="form-label">SOBRENOME</label>
                <input type="text" id="surname" name="surname" class="form-control" placeholder="Digite seu sobrenome" value="{{ old('surname') }}">
                @error('surname')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- E-mail e Senha --}}
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">E-MAIL</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Digite seu e-mail" value="{{ old('email') }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">SENHA</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Digite sua senha" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- DDD e Telefone --}}
            <div class="col-md-2 mb-3">
                <label for="ddd" class="form-label">DDD</label>
                <input type="text" id="ddd" name="ddd" class="form-control" placeholder="+55" value="{{ old('ddd') }}" maxlength="3">
                @error('ddd')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-10 mb-3">
                <label for="phone" class="form-label">TELEFONE</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="Digite seu telefone" value="{{ old('phone') }}">
                @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Checkboxes --}}
            <div class="col-12">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" {{ old('newsletter') ? 'checked' : '' }}>
                    <label class="form-check-label" for="newsletter">
                        Desejo receber informações sobre novidades de Nocturne no meu e-mail
                    </label>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="privacy_policy" name="privacy_policy" value="1" required>
                    <label class="form-check-label" for="privacy_policy">
                        Li e entendi a <a href="{{ route('privacy.cookies') }}" class="text-decoration-underline">Política de Privacidade de Cookies</a>
                    </label>
                    @error('privacy_policy')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Botão de envio --}}
        <div class="text-end">
            <button type="submit" class="btn btn-outline-dark px-4 py-2">CRIAR CONTA</button>
        </div>
    </form>
</div>
@endsection
