<?php

namespace App\Services\Theme;

use App\Models\Category;

class HeaderService
{
    public function get()
    {
        $headers = [];

        $categories = Category::where([])->get();

        array_push($headers, (object)[
            'title' => 'Home',
            'url' => route('home')
        ]);

        foreach ($categories as $category) {
            array_push($headers, (object)[
                'title' => $category->name,
                'url' => route('store.categories.show', $category)
            ]);
        }

        return $headers;
    }
}