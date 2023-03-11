<?php

namespace App\Http\Controllers;

use App\Models\TemporaryProduct;
use Illuminate\Http\Request;
use App\Services\Search\SearchService;
use Yajra\DataTables\Facades\DataTables;

class TemporaryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = TemporaryProduct::all();
        return view('temporary_product.index', [
            'products' => $products
        ]);
    }

    public function getData(Request $request)
    {
        $productQuery = TemporaryProduct::with(['imageTable','vendor']);

        if (auth()->user()->isVendor()) {
            $productQuery = $productQuery->where(['vendor_id' => auth()->user()->id]);
        }

        if (isset($request->search) && is_array($request->search) && $request->search['value'] != '') {
            $searchValue = strtolower($request->search['value']);
            $suggestionWords = SearchService::getSearchKeyword($searchValue);
            $productQuery->where(function ($query) use ($suggestionWords, $searchValue) {
                $query->orWhere('name', 'LIKE', "%{$searchValue}%");
                foreach ($suggestionWords as $word) {
                    $query->orWhereRaw('`name` LIKE ?', ['%' . trim(strtolower($word)) . '%']);
                }
            });
        }

        if (!request()->get('order')) {
            $productQuery = $productQuery->orderBy('updated_at', 'desc');
        }

        return Datatables::of($productQuery)
            ->filter(function ($query) use ($request) {
            })
            ->editColumn('name', function ($model) {
                return $model->name . " - <b>(" . bnConvert()->number($model->quantity) . " " . bnConvert()->unit($model->unit) . ")</b>";
            })
            ->editColumn('profit', function ($model) {
                return $this->addPriceLabel($model->profit);
            })
            ->editColumn('wholesale_price', function ($model) {
                return $this->addPriceLabel($model->wholesale_price);
            })
            ->editColumn('market_sale_price', function ($model) {
                return $this->addPriceLabel($model->market_sale_price);
            })
            ->editColumn('delivery_fee', function ($model) {
                return $this->addPriceLabel($model->delivery_fee == '' ? 19 : $model->delivery_fee);
            })
            ->editColumn('price', function ($model) {
                return $this->addPriceLabel($model->price);
            })
            ->editColumn('image', function ($model) {
                return "<img src='" . $model->image . "' height='50px' width='50px' class='img-fluid img-thumbnail'>";
            })
            ->editColumn('updated_at', function ($model) {
                return bnConvert()->date($model->updated_at->diffForHumans());
            })
            
            ->addColumn('action', function ($model) {
                $content = '';
                
                return $content;
            })
            ->make(true);
    }

    private function addPriceLabel($price)
    {
        return '<span class="badge"><span style="font-size: 14px;">' . bnConvert()->number($price) . '</span><span style="color:#636e72;"> ৳ </span></span>';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
