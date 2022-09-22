<?php

namespace App\Http\Controllers;

use App\Models\SearchKeyword;
use App\Models\SearchKeywordValue;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SearchKeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('search_keyword.index');
    }

    public function getData(Request $request)
    {
        $searchKeywordQuery = SearchKeyword::where([]);

        if (!request()->get('order')) {
            $searchKeywordQuery = $searchKeywordQuery->orderBy('id', 'desc');
        }
    
        return Datatables::of($searchKeywordQuery)
            ->filter(function ($query) use ($request) {
            })
            ->addColumn('total_values', function ($searchKeyword) {
                
                return $searchKeyword->values()->count();
            })
            ->addColumn('values', function ($searchKeyword) {
                $values = $searchKeyword->values;
                $content = '';
                foreach ($values as $key => $value) {
                    $color = ($key%6) + 1;
                    $content .= "<span class='badge tag-color-".$color." mr-1'>" . $value->value . "</span>";
                }
                return $content;
            })
            ->addColumn('action', function ($model) {
                $content = "<button data-url='" . route('search-keywords.edit', ['search_keyword' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' data-modal-title='Update Keyword <b>#" . $model->id . "</b>'
                data-modal-size='650' data-toggle='modal'><i class='fa fa-edit'></i></button>";
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
        $searchKeyword = SearchKeyword::findOrFail($id);
        return view('search_keyword.edit', ['searchKeyword' => $searchKeyword]);
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
        $searchKeyword = SearchKeyword::findOrFail($id);
        $searchKeyword->values()->delete();
        $searchValues = $request->values;
        foreach ($searchValues as $key => $value) {
           SearchKeywordValue::create([
            'search_keyword_id' => $searchKeyword->id,
            'value' => $value
           ]);
        }
        return response()->json([
            'message' => 'Keyword Successfully Updated'
        ]);
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
