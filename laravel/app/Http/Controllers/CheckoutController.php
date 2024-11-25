<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Busca o endereço da sessão ou do banco de dados (caso o usuário esteja logado)
        $address = session('checkout_address', []);
        
        if (auth()->check() && !$address) {
            $address = Address::where('user_id', auth()->id())
                ->where('is_default', 1)
                ->first();
        }

        // Recupera o carrinho da sessão
        $cart = session('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Verifica se há um cupom aplicado
        $discount = 0;
        if (session()->has('coupon')) {
            $coupon = session('coupon');

            // Aplica o desconto com base no tipo do cupom
            if ($coupon['type'] === 'percentage') {
                $discount = ($total * $coupon['discount']) / 100;
            } elseif ($coupon['type'] === 'fixed') {
                $discount = $coupon['discount'];
            }

            // Garante que o desconto não ultrapasse o total
            $discount = min($discount, $total);
            $total -= $discount; // Subtrai o desconto do total
        }

        // Salva o total atualizado na sessão
        session(['cart_total' => $total]);

        // Renderiza a página de checkout
        return view('checkout.index', compact('cart', 'total', 'address', 'discount'));
    }


    public function saveAddress(Request $request)
    {
        $request->validate([
            'cep' => 'required|string|max:10',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);

        // Salva o endereço na sessão
        $address = $request->only(['cep', 'street', 'number', 'neighborhood', 'city', 'state']);
        session(['checkout_address' => $address]);

        return redirect()->route('checkout.index')->with('success', 'Endereço salvo com sucesso!');
    }

}
