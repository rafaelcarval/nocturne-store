<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // 8 produtos aleatórios para o carrossel de Store
        $storeProducts = Product::where('type', 'Store')
            ->inRandomOrder()
            ->take(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'image' => $product->images->first()->image_path ?? 'images/default-product.jpg',
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                ];
            });

        // 8 produtos aleatórios para o carrossel de Thrift Store
        $thriftProducts = Product::where('type', 'Thrift Store')
            ->inRandomOrder()
            ->take(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'image' => $product->images->first()->image_path ?? 'images/default-product.jpg',
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                ];
            });

        return view('home', compact('storeProducts', 'thriftProducts'));
    }
    
}
