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

    public static function getWordsList($searchValue)
    {
        $specialCharList = ['(', ')', '-', ',', '।', '[', ']', '{', '}', '_'];
        $searchValue = str_replace($specialCharList, ' ', $searchValue);
        $words = explode(' ', $searchValue);
        foreach ($words as $key => $value) {
            $value = trim($value);
            if ($value == "") unset($words[$key]);
        }

        return $words;
    }

    public static function getSearchKeyword($searchValue)
    {

        $words = self::getWordsList($searchValue);
        if (empty($words)) return [];

        $suggestionWords = SearchKeywordValue::where(function ($query) use ($words) {
            foreach ($words as $word) {
                $query->orWhere('value', 'LIKE', "%{$word}%");
            }
        })
            ->leftJoin('search_keywords', 'search_keywords.id', '=', 'search_keyword_values.search_keyword_id')
            ->select('key')
            ->groupBy('key')
            ->pluck('key')
            ->toArray();

        $products = Product::where(function ($query) use ($words, $searchValue) {
            $query->orWhere('name', 'LIKE', "%{$searchValue}%");
            foreach ($words as $word) {
                $query->orWhereRaw('`name` LIKE ?', ['%' . trim(strtolower($word)) . '%']);
            }
        })->distinct('name')->pluck('name')->toArray();

        $suggestionWords = array_merge($suggestionWords, $words, $products);

        return $suggestionWords;
    }

    public static function getSearchProduct($searchValue)
    {
        if ($searchValue == "") return [];
        $searchValue = strtolower($searchValue);
        $suggestionWords = self::getSearchKeyword($searchValue);
        // dd($suggestionWords);
        $products = Product::where(function ($query) use ($suggestionWords, $searchValue) {
            $query->orWhere('name', 'LIKE', "%{$searchValue}%");
            foreach ($suggestionWords as $word) {
                $query->orWhereRaw('`name` LIKE ?', ['%' . trim(strtolower($word)) . '%']);
            }
        });

        // dd($products);

        return $products;
    }

    public static function getSearchSortableProduct($searchValue)
    {
        $products = self::getSearchProduct($searchValue)->get();
        $products->map(function ($product) use ($searchValue) {
            $product->search_match = self::percentageMatch($searchValue, $product->name);
            return $product;
        });

        $products = $products->sortByDesc('search_match');

        return $products;
    }


    public static function  percentageMatch($str1, $str2)
    {
        $similarity = self::jaccardSimilarity($str1, $str2);
        $percentage = $similarity * 100;
        return $percentage;
    }

    public static function jaccardSimilarity($str1, $str2)
    {
        $set1 = str_split($str1);
        $set2 = str_split($str2);

        $intersection_size = count(array_intersect($set1, $set2));
        $union_size = count(array_unique(array_merge($set1, $set2)));

        return $intersection_size / $union_size;
    }
}
