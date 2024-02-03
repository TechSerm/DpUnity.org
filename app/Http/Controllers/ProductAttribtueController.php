<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use AWS\CRT\HTTP\Request;
use Illuminate\Support\Str;

class ProductAttribtueController extends Controller
{
    public function create(Product $product)
    {
        $attributes = Attribute::whereNotIn('id', $product->attributes->pluck('attribute_id'))->get();
        return view('product.edit.attribute.create', ['attribtues' => $attributes]);
    }

    public function store(Product $product)
    {
        $attribute = Attribute::whereNotIn('id', $product->attributes->pluck('attribute_id'))->where(['uuid' => request()->attribute_id])->firstOrFail();
        $attributeValues = $attribute->values()->whereIn('uuid', request()->attribute_values ?? [])->get();

        if ($product->attributes()->where('attribute_id', $attribute->id)->exists()) {
            return response()->json([
                'message' => 'This attribute already added'
            ], 401);
        }

        $productAttribute = ProductAttribute::create([
            'uuid' => Str::uuid(),
            'product_id' => $product->id,
            'attribute_id' => $attribute->id
        ]);

        foreach ($attributeValues as $attributeValue) {
            ProductAttributeValue::create([
                'uuid' => Str::uuid(),
                'product_attribute_id' => $productAttribute->id,
                'attribute_value_id' => $attributeValue->id
            ]);
        }

        return view('product.edit.attribute.create', ['attribtues' => Attribute::all()]);
    }

    public function edit(Product $product, ProductAttribute $productAttribute)
    {
        return view('product.edit.attribute.edit', ['attribute' => $productAttribute]);
    }

    public function update(Product $product)
    {
        $productAttribute = $product->attributes()->where(['uuid' => request()->product_attribute])->firstOrFail();
        $productAttributeValues = $productAttribute->values;

        $attribute = $productAttribute->attribute;
        $selectedAttributeValues = $attribute->values()->whereIn('uuid', request()->attribute_values ?? [])->get();
        $selectedAttributeValueIds = $selectedAttributeValues->pluck('id');

        foreach ($productAttributeValues as $productAttributeValue) {
            if ($selectedAttributeValueIds->contains($productAttributeValue->value->id)) continue;
            $productAttributeValue->delete();
        }

        $productAttributeValues = $productAttribute->values()->get();
        $productAttributeValueIds = $productAttributeValues->pluck('attribute_value_id');

        foreach ($selectedAttributeValues as $selectedAttributeValue) {
            if ($productAttributeValueIds->contains($selectedAttributeValue->id)) continue;

            ProductAttributeValue::create([
                'uuid' => Str::uuid(),
                'product_attribute_id' => $productAttribute->id,
                'attribute_value_id' => $selectedAttributeValue->id
            ]);
        }

        return response()->json([
            'message' => 'Successfully updated attribute'
        ]);
    }

    public function getSelect2Data()
    {
        $attribute = Attribute::where(['uuid' => request()->attribtue])->firstOrFail();

        return $attribute->values;
    }

    public function destroy(Product $product, ProductAttribute $productAttribute)
    {
        $productAttribute->delete();

        return response()->json([
            'message' => 'Successfully deleted attribute'
        ]);
    }

    private function createVariants()
    {
        
    }
}
