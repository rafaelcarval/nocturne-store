<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Exibe o formulário de criação de cliente.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Salva os dados do cliente.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Nome obrigatório, texto, máximo de 255 caracteres
            'surname' => 'nullable|string|max:255', // Sobrenome opcional
            'email' => 'required|email|unique:clients,email', // E-mail obrigatório, formato válido, único
            'password' => 'required|string|min:6|confirmed', // Senha obrigatória, mínimo 6 caracteres, confirmação necessária
            'ddd' => 'nullable|string|max:3|regex:/^\d{2,3}$/', // DDD opcional, máximo de 3 dígitos, validação de formato
            'phone' => 'nullable|string|max:15|regex:/^\d{8,15}$/', // Telefone opcional, máximo de 15 dígitos, validação de formato
            'newsletter' => 'nullable|boolean', // Opção de newsletter opcional
            'privacy_policy' => 'required|boolean|in:1', // Obrigatório e deve ser verdadeiro
        ], [
            'name.required' => 'O campo Nome é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Digite um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
            'privacy_policy.required' => 'Você deve aceitar a Política de Privacidade.',
        ]);

        // Salva o cliente no banco de dados
        Client::create([
            'name' => $validated['name'],
            'surname' => $validated['surname'] ?? null,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Senha criptografada
            'ddd' => $validated['ddd'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'newsletter' => $request->has('newsletter'), // True se o checkbox for marcado
            'privacy_policy' => $validated['privacy_policy'],
        ]);

        // Retorna uma mensagem de sucesso
        return redirect()->route('clients.create')->with('success', 'Cliente cadastrado com sucesso!');
    }
}
