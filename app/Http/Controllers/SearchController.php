<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $searchQuery = request()->q ?? '';
        return view('store.search.index', [
            'products' => $this->getProduct(),
            'searchQuery' => $searchQuery
        ]);
    }

    public function getSearchProduct()
    {
        return view('store.product.single_product_page', [
            'products' => $this->getProduct()
        ]);
    }

    private function getProduct()
    {
        $searchQuery = request()->q;
        if($searchQuery == "")return [];
        $products = Product::where('name', 'LIKE', "%{$searchQuery}%")->get();

        $products = Product::where(function ($query) {
            $searchQuery = request()->q;
            $query->where('name', 'LIKE', "%{$searchQuery}%");
            $query->orWhere('slug', 'LIKE', "%{$searchQuery}%");
        })->toSql();

        dd($products);


        return $products;
    }
}
