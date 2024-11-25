<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Exibe o formulário de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Processa o login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenta autenticar como usuário
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->type === 'admin') {
                // Redireciona para o dashboard se for admin
                return redirect()->route('dashboard');
            }

            // Redireciona para a home se for cliente
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ])->onlyInput('email');
    }

    /**
     * Processa o logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Exibe o formulário de cadastro de cliente.
     */
    public function createClient()
    {
        return view('clients.create');
    }

    /**
     * Salva os dados do cliente.
     */
    public function storeClient(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'ddd' => 'nullable|string|max:3|regex:/^\d{2,3}$/',
            'phone' => 'nullable|string|max:15|regex:/^\d{8,15}$/',
            'newsletter' => 'nullable|boolean',
            'privacy_policy' => 'required|boolean|in:1',
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

        User::create([
            'name' => $validated['name'],
            'surname' => $validated['surname'] ?? null,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => 'customer', // Define como cliente
            'ddd' => $validated['ddd'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'newsletter' => $request->has('newsletter'),
            'privacy_policy' => $validated['privacy_policy'],
        ]);

        return redirect()->route('clients.create')->with('success', 'Cliente cadastrado com sucesso!');
    }
}
