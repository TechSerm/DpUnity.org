<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings = Shipping::all();
        return view('shipping.index', [
            'shippings' => $shippings
        ]);
    }

    public function getData(Request $request)
    {
        $productQuery = Shipping::where([]);

        return Datatables::of($productQuery)
            ->filter(function ($query) use ($request) {
            })

            ->editColumn('updated_at', function ($model) {
                return $model->updated_at->diffForHumans();
            })
            ->addColumn('action', function ($model) {

                $content = "<button data-url='" . route('shipping.edit', ['shipping' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update Product <b>#" . $model->woo_id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";
                $content .= "<button data-url='" . route('shipping.destroy', ['shipping' => $model->id]) . "' class='btn btn-danger btn-action btn-sm' data-callback='reloadProductDatatable()' data-toggle='delete'><i class='fa fa-trash'></i></button>";

                return $content;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shipping.create');
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
