<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class StoreCategoryController extends Controller
{
    public function index(){
        $categories = Category::all();

        return view('store.category.index', [
            'categories' => $categories
        ]);
    }

    public function show(){

        $category = Category::findOrFail(request()->category);

        return view('store.category.show', [
            'products' => $category->products,
            'category' => $category
        ]);
    }
}
