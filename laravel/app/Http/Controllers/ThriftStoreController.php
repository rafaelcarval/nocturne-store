<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ThriftStoreController extends Controller
{
    public function index(Request $request)
    {
        // Obter as categorias
        $categories = Category::all();

        // Buscar produtos do tipo "Store" com imagens relacionadas
        $query = Product::where('type', 'Thrift Store')->with('images');

        // Filtrar por categoria, se selecionado
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filtrar por busca, se preenchido
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Paginar os resultados
        $products = $query->paginate(8);

        return view('thrift_store.index', compact('products', 'categories'));
    }
    
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id); // Carrega o produto e sua categoria
        return view('thrift_store.show', compact('product'));
    }

}
