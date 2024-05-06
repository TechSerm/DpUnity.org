<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

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
        if ($searchQuery == "") return [];
        $products = SearchService::getSearchSortableProduct($searchQuery)->where('status', 'publish');
        $this->totalProducts = $products->count();

        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $total ? $this : $this->forPage($page, $perPage)->values(),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        return $products->paginate(12);
    }
}
