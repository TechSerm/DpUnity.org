<?php

namespace App\Services\Search;

use App\Models\Product;
use App\Models\SearchKeyword;
use App\Models\SearchKeywordValue;
use Illuminate\Support\Facades\DB;

class SearchService
{
    public static function createSearchKeyword($name)
    {
        $specialCharList = ['(', ')', '-', ',', '।', '[', ']', '{', '}', '_'];
        $name = str_replace($specialCharList, ' ', $name);

        $words = explode(' ', $name);
        foreach ($words as $key => $value) {
            $value = trim($value);
            if ($value == "") unset($words[$key]);
        }

        foreach ($words as $key => $value) {
            if (SearchKeyword::where('key', '=', $value)->exists()) continue;
            SearchKeyword::create([
                'key' => $value
            ]);
        }
    }

    public static function getWordsList($searchValue){
        $specialCharList = ['(', ')', '-', ',', '।', '[', ']', '{', '}', '_'];
        $searchValue = str_replace($specialCharList, ' ', $searchValue);
        $words = explode(' ', $searchValue);
        foreach ($words as $key => $value) {
            $value = trim($value);
            if ($value == "") unset($words[$key]);
        }

        return $words;
    } 

    public static function getSearchKeyword($searchValue){
        
        $words = self::getWordsList($searchValue);
        if(empty($words))return [];

        $suggestionWords = SearchKeywordValue::where(function($query) use ($words){
            foreach ($words as $word) {
                $query->orWhere('value', 'LIKE', "%{$word}%");
            }
        })
        ->leftJoin('search_keywords', 'search_keywords.id', '=', 'search_keyword_values.search_keyword_id')
        ->select('key')
        ->groupBy('key')
        ->pluck('key')
        ->toArray();

        $products = Product::where(function($query) use($words, $searchValue){
            $query->orWhere('name', 'LIKE', "%{$searchValue}%");
            foreach ($words as $word) {
                $query->orWhereRaw('`name` LIKE ?', ['%'.trim(strtolower($word)).'%']);
            }
        })->distinct('name')->pluck('name')->toArray();

        $suggestionWords = array_merge($suggestionWords, $words, $products);

        return $suggestionWords;
    }

    public static function getSearchProduct($searchValue){
        if($searchValue == "")return [];
        $searchValue = strtolower($searchValue);
        $suggestionWords = self::getSearchKeyword($searchValue);
       // dd($suggestionWords);
        $products = Product::where(function($query) use($suggestionWords, $searchValue){
            $query->orWhere('name', 'LIKE', "%{$searchValue}%");
            foreach ($suggestionWords as $word) {
                $query->orWhereRaw('`name` LIKE ?', ['%'.trim(strtolower($word)).'%']);
            }
        });

       // dd($products);

        return $products;
    }
}
