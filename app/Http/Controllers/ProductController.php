<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SaleUnit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::getMainProducts();

        return view('app.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $saleUnits = SaleUnit::all('title');
        return view('app.product.create', compact('saleUnits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            // 'photos'=> [
            //     'required',
            //     'image',
            //     'mimes:jpg,jpeg,png,gif',
            // ]
        ]);

        $inventoryProduct = $request->except(['_token','su_name','su_price','su_original_price','photos','price','original_price']);
        $pattern = '/\s+/';
        $inventoryProduct['price'] =converPriceStringToInt($request->price);
        $inventoryProduct['original_price'] =converPriceStringToInt($request->original_price);
        $lastSKU = Product::latest()->first()->SKU;
        $inventoryProduct['SKU'] = Product::generateSKU($lastSKU);
        if($product = Product::create($inventoryProduct)){
            if($request->filled('su_name')){
                $numberOfSaleUnit = count($request->su_name);
                $skuList = Product::generateMultipleSKUs($inventoryProduct['SKU'], $numberOfSaleUnit);
                foreach($request->su_name as $key=>$value){
                    $sale_unit = [];
                    $sale_unit['name']= $product->name;
                    $sale_unit['parent_id']= $product->id;
                    $sale_unit['sale_unit']= $value;
                    $sale_unit['price']= converPriceStringToInt($request->su_price[$key]);
                    $sale_unit['original_price']= converPriceStringToInt($request->su_original_price[$key]);
                    $sale_unit['SKU'] = $skuList[$key];
                    $saleUnitProduct = Product::create($sale_unit);
                }
            }

            if($request->hasFile('photos')){
                foreach($request->file('photos') as $photo){
                    if($photo->isValid()){
                        $product->addMedia($photo)->toMediaCollection('product');
                    }
                }
            }

            $notifycation = [
                'message' => 'Sản phẩm tạo thành công',
                'alert-type' =>'success'
            ];
            return redirect()->route('products.index')->with($notifycation);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('app.product.detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    // -----------------ajax function--------------------//
    public function ajaxStore(Request $request){
        return response()->json(['ok'=>'pk']);
    }
    // end-----------------ajax function--------------------//
}
