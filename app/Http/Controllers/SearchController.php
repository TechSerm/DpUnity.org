<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Search\SearchService;
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
        return SearchService::getSearchSortableProduct($searchQuery)->forPage(request()->page, 5);
    }
}
