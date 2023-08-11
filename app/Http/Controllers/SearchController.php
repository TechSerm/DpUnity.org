<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $totalProducts;

    public function index()
    {
        $searchQuery = request()->q ?? '';
        return view('store.search.index', [
            'products' => $this->getProduct(),
            'searchQuery' => $searchQuery,
            'totalProducts' => $this->totalProducts
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
        $products = SearchService::getSearchSortableProduct($searchQuery)->where('status', 'publish');
        $this->totalProducts = $products->count();
        return $products->forPage(request()->page, 6);
    }
}
