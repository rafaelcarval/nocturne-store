<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateCartTotal();
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->images->first()->image_path ?? 'images/default-product.jpg',
                'quantity' => $request->input('quantity', 1),
                'size' => $request->input('size', null),
                'available_sizes' => $product->sizes_array,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produto removido do carrinho!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->input('quantity', $cart[$id]['quantity']);
            $cart[$id]['size'] = $request->input('size', $cart[$id]['size']);
            session(['cart' => $cart]);

            return response()->json([
                'success' => true,
                'subtotal' => $cart[$id]['price'] * $cart[$id]['quantity'],
                'total' => $this->calculateCartTotal()
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon' => 'required|string|max:255']);
        $couponCode = $request->input('coupon');
        
        if (session()->has('coupon')) {
            session()->forget('coupon');
        }
        // Busca o cupom no banco de dados
        $coupon = Coupon::where('code', $couponCode)->first();

        // Validações do cupom
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Cupom não encontrado.'], 404);
        }

        if ($coupon->quantity <= $coupon->used) {
            return response()->json(['success' => false, 'message' => 'Este cupom já foi utilizado.'], 400);
        }

        if (now()->greaterThan($coupon->expires_at)) {
            return response()->json(['success' => false, 'message' => 'Este cupom já expirou.'], 400);
        }

        // Calcula o total do carrinho
        $cartTotal = $this->calculateCartTotal();
        $discount = 0;

        // Calcula o desconto com base no tipo do cupom
        if ($coupon->type === 'percentage') {
            $discount = ($cartTotal * $coupon->discount) / 100;
        } elseif ($coupon->type === 'fixed') {
            $discount = $coupon->discount;
        }

        // Garante que o desconto não ultrapasse o total
        $discount = min($discount, $cartTotal);

        // Atualiza o campo 'used' no banco de dados
        $coupon->used += 1;
        $coupon->save();

        // Armazena os dados do cupom na sessão
        session(['coupon' => [
            'code' => $coupon->code,
            'discount' => $coupon->discount,
            'type' => $coupon->type,
        ]]);

        // Calcula o novo total com desconto
        $newTotal = $cartTotal - $discount;

        // Retorna os dados ao frontend
        return response()->json([
            'success' => true,
            'message' => 'Cupom aplicado com sucesso!',
            'total' => $newTotal, // Total com desconto aplicado
            'discount' => $discount // Valor do desconto
        ]);
    }



    public function calculateCartTotal()
    {
        $cart = session('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Verifica se há um cupom aplicado
        if (session()->has('coupon')) {
            $coupon = session('coupon');
            
            // Aplica o desconto com base no tipo
            if ($coupon['type'] === 'percentage') {
                $discount = ($total * $coupon['discount']) / 100;
            } elseif ($coupon['type'] === 'fixed') {
                $discount = $coupon['discount'];
            } else {
                $discount = 0;
            }

            // Garantir que o desconto não exceda o total
            $discount = min($discount, $total);
            $total -= $discount;
        }

        return $total;
    }


    public function calculateFreight(Request $request)
    {
        $cep = $request->input('frete');

        if (!preg_match('/^\d{5}-?\d{3}$/', $cep)) {
            return response()->json(['error' => 'CEP inválido!'], 400);
        }

        $response = file_get_contents("https://viacep.com.br/ws/{$cep}/json/");
        $addressData = json_decode($response, true);

        if (isset($addressData['erro']) && $addressData['erro']) {
            return response()->json(['error' => 'CEP não encontrado!'], 404);
        }

        // Mapeia os campos para o formato esperado
        $formattedAddress = [
            'cep' => $addressData['cep'],
            'street' => $addressData['logradouro'],
            'neighborhood' => $addressData['bairro'],
            'city' => $addressData['localidade'],
            'state' => $addressData['uf'],
            'region' => $addressData['regiao'] ?? null, // Adicionado como exemplo
            'complement' => $addressData['complemento'] ?? null,
        ];

        // Salva o endereço formatado na sessão
        session(['checkout_address' => $formattedAddress]);

        return response()->json([
            'success' => true,
            'freight' => 15.00, // Simulação de valor do frete
            'address' => $formattedAddress,
        ]);
    }

    public function removeCoupon()
    {
        // Remove o cupom da sessão
        session()->forget('coupon');

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Cupom removido com sucesso.');
    }


}
