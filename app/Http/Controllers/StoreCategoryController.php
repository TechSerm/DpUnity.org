<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class StoreCategoryController extends Controller
{
    public function index(){
        $categories = Category::active()->with('imageTable', 'products')->get();

        return view('store.category.index', [
            'categories' => $categories
        ]);
    }

    public function show(){

        $category = Category::active()->findOrFail(request()->category);

        return view('store.category.show', [
            'products' => $category->products()->with('imageTable')->where(['status' => 'publish'])->orderBy('has_stock', 'desc')->orderBy('serial')->get(),
            'category' => $category
        ]);
    }
}
