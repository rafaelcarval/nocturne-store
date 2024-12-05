@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Contato</h1>
    <p class="mb-4">
        Queremos ouvir você! Seja para esclarecer dúvidas, receber feedbacks ou oferecer suporte, nossa equipe está 
        pronta para ajudar. Entre em contato conosco preenchendo o formulário abaixo:
    </p>
    <form action="#" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Seu nome completo" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="seuemail@exemplo.com" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Mensagem</label>
            <textarea id="message" name="message" class="form-control" rows="5" placeholder="Digite sua mensagem" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    <p class="mt-4">
        Você também pode entrar em contato através do nosso e-mail: 
        <a href="mailto:contato@nocturne.com.br">contato@nocturne.com.br</a>.
    </p>
</div>
@endsection
