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
        if(Product::count()>0){
            $lastSKU = Product::latest()->first()->SKU;
        }else{
            $lastSKU = '0';
        }
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
                        $product->addMedia($photo)->toMediaCollection('inventory_product');
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
        // return view('app.product.detail', compact('product'));
        // return product as json
        $data = $product->load('media','children')->toArray();
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $saleUnits = SaleUnit::all('title');
        return view('app.product.edit', compact('product','saleUnits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'price'=>'required'
        ]);
        $mainProduct = $request->except(['_token',
                                            'su_name',
                                            'su_price',
                                            'su_original_price',
                                            'image',
                                            'current_su_id',
                                            'current_su_name',
                                            'current_su_price',
                                            'current_su_original_price',

                                        ]);
        // ------- update main product------------
        $mainProductUpdated = $product->update($mainProduct);

        //----------update sale unit-------------
        if($mainProductUpdated ){
            // --------work with current sale unit product----------
            // value of array key=>value
            $currentSUIdInForm = $request->current_su_id;
            // value of collection of model
            $currentSuInDB = $product->children;
            foreach($currentSuInDB as $child){
                // delete this sale unit product bs this item has been deleted by user
                if(!in_array($child->id,  $currentSUIdInForm)){
                    $child->delete();
                }
                // update sale unit that present in the form
                foreach($request->current_su_id as $key=>$value){
                    $sale_unit = [];
                    $sale_unit['name']= $product->name;
                    $sale_unit['parent_id']= $product->id;
                    $sale_unit['sale_unit']= $request->current_su_name[$key];
                    $sale_unit['price']= $request->current_su_price[$key];
                    $sale_unit['original_price']= $request->current_su_original_price[$key];
                    $currentId = (int)$value;
                    Product::findOrFail($currentId)->update($sale_unit);
                }
            }
            // work with new added sale unit product
            if($request->filled('su_name')){
                $numberOfSaleUnit = count($request->su_name);
                $skuList = Product::generateMultipleSKUs($product['SKU'], $numberOfSaleUnit);
                foreach($request->su_name as $key=>$value){
                    $sale_unit = [];
                    $sale_unit['name']= $product->name;
                    $sale_unit['parent_id']= $product->id;
                    $sale_unit['sale_unit']= $value;
                    $sale_unit['price']= $request->su_price[$key];
                    $sale_unit['original_price']= $request->su_original_price[$key];
                    $sale_unit['SKU'] = $skuList[$key];
                    $saleUnitProduct = Product::create($sale_unit);
                }
            }

            // work with image
            if($request->hasFile('image') && $request->file('image')->isValid()){
                // delete old image
                if($product->getFirstMedia('inventory_product')){
                    $product->getFirstMedia('inventory_product')->delete();
                }
                // add new image
                $product->addMediaFromRequest('image')->toMediaCollection('inventory_product');
            }
            $notifycation = [
                'message' => 'Sản phẩm cập nhật thành công',
                'alert-type' =>'success'
            ];
            return redirect()->route('products.index')->with($notifycation);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        $notification = [
            'message' => 'xóa sản phẩm thành công',
            'alert-type' =>'success'
        ];
        return redirect(route('products.index'))->with($notification);
    }
    public function deleted(){
        $products = Product::onlyTrashed()->get();
        return view('app.product.deleted', compact('products'));
    }
    public function restore(Product $product){
        $product->restore();
        $notifycation = [
            'message' => 'Khôi phục sản phẩm thành công',
            'alert-type' =>'success'
        ];
        return redirect()->back()->with($notifycation);
    }

    // -----------------ajax function--------------------//
    public function ajaxStore(Request $request){
        return response()->json(['ok'=>'pk']);
    }
    // end-----------------ajax function--------------------//
}
