<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Models\Province;
use App\Models\SaleUnit;
use App\Models\Ward;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$invoices = Invoice::latest()->get();
        //$invoices = Invoice::all();
        return view('app.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $now = Carbon::now()->format('d-m-Y H:i:s');
        $now = date('d-m-Y H:i:s');
        $saleUnits = SaleUnit::all('title');
        $invoiceNumber = 'HD-'.strtoupper(uniqid());
        return view('app.invoice.create', compact('invoiceNumber','saleUnits','now'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->customer_id){
            $notification = array(
                'message'=>'hóa đơn chưa có khách hàng',
                'alert-type'=>'error'
            );
            return redirect()->back()->with($notification);
        }
        // $test = date('Y-m-d H:i:s',strtotime($request->invoice_date_holder));
        // dd($test);
        // dd($request->invoice_date);
        $invoice = new Invoice();
        $invoice->date = $request->invoice_date_holder?date('Y-m-d', strtotime($request->invoice_date_holder)):date('Y-m-d');
        $invoice->invoice_no = $request->invoice_no_holder;
        $invoice->customer_id = $request->customer_id;
        $invoice->subtotal = $request->invoice_subtotal;
        if($request->shipping_fee){
            $invoice->shipping = $request->shipping_fee;
        }else{
            $invoice->shipping = 0;
        }
        if($request->invoice_amount_off){
            $invoice->amount_off = $request->invoice_amount_off;
        }
        $invoice->total = $request->product_total;
        $invoice->status ='0';
        $invoice->note = $request->note;
        // dd($invoice->date);

        DB::transaction(function() use($request,$invoice){
            if ($invoice->save()) {
               $productCount = count($request->product_id);
               for ($i=0; $i < $productCount ; $i++) {

                  $invoiceDetail = new InvoiceDetail();
                  $invoiceDetail->date = $invoice->date?$invoice->getRawOriginal("date"):date('d-m-Y');
                //   dd($invoiceDetail->date);
                //   dd($invoiceDetail->date);
                //   $invoiceDetail->date = date('Y-m-d H:i:s',strtotime($request->invoice_date_holder));
                  $invoiceDetail->invoice_id = $invoice->id;

                  // each product
                  $invoiceDetail->product_id = $request->product_id[$i];
                  $invoiceDetail->quantity = $request->product_quantity[$i];
                  if($request->product_amount_off[$i]){
                    $invoiceDetail->amount_off = $request->product_amount_off[$i];// does it need?
                  }
                  $invoiceDetail->selling_price = $request->selling_price[$i]?$request->selling_price[$i]:0;
                  $invoiceDetail->line_total = $request->product_line_total[$i];

                  $invoiceDetail->status = '1';
                  $invoiceDetail->save();
               }

            }
        });
        $notification = array([
            'message'=>'Tạo thành công hóa đơn',
            'alert-type'=>'success'
        ]);
        return redirect()->route('invoices.index')->with($notification);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return response()->json($invoice->load('customer','invoiceDetails','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        // // $invoice = Invoice::findOrFail($request->invoiceId);
        // dd($invoice->id);
        // $invoice = $invoice->load('customer.addresses.zone','customer.addresses.ward');
        $customerId = $invoice->customer->id;
        $saleUnits = SaleUnit::all('title');
        // dd($invoice);
        return view('app.invoice.edit', compact('customerId','invoice', 'saleUnits'));
    }
    public function ajaxCreateProduct(Request $request){
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            // 'photos'=> [
            //     'required',
            //     'image',
            //     'mimes:jpg,jpeg,png,gif',
            // ]
        ]);
        // $product =[];
        // $product['name'] = converPriceStringToInt($request->name);
        // $product['price'] = converPriceStringToInt($request->price);
        // $product['original_price'] = converPriceStringToInt($request->original_price);
        // $lastSKU = Product::latest()->first()->SKU;
        // $product['SKU'] = Product::generateSKU($lastSKU);

        $product = $request->except(['_token','su_name','su_price','su_original_price','photos','price','original_price']);
        $product['price'] =converPriceStringToInt($request->price);
        $product['original_price'] =converPriceStringToInt($request->original_price);
        if(Product::all()->count()>0){// have atleast 1 product
            $lastSKU = Product::latest()->first()->SKU;
        }else{
            $lastSKU = 000001;
        }
        $product['SKU'] = Product::generateSKU($lastSKU);
        if($product = Product::create($product)){
            if($request->filled('su_name')){
                $numberOfSaleUnit = count($request->su_name);
                $skuList = Product::generateMultipleSKUs($product['SKU'], $numberOfSaleUnit);
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
            return response()->json($product);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //dd($request->all());

        $invoice->subtotal = $request->invoice_subtotal;
        if($request->shipping_fee){
            $invoice->shipping = $request->shipping_fee;
        }else{
            $invoice->shipping = 0;
        }
        // $invoice->amount_off = $request->invoice_amount_off;
        if($request->invoice_amount_off){
            $invoice->amount_off = $request->invoice_amount_off;
        }
        $invoice->total = $request->product_total;
        $invoice->status ='0';
        $invoice->note = $request->note;
        //echo($request->invoice_subtotal);
        DB::transaction(function() use($request,$invoice){
            if ($invoice->save()) {
                // delete all invoice_detail relative with this invoice
                $invoice->invoiceDetails->each(function($invoiceDetail) {
                    $invoiceDetail->delete();
                });
               $productCount = count($request->product_id);
               for ($i=0; $i < $productCount ; $i++) {

                  $invoiceDetail = new InvoiceDetail();
                //   $invoiceDetail->date = $request->invoice_date_holder;
                    $invoiceDetail->date = date('Y-m-d H:i:s',strtotime($request->invoice_date_holder));
                  $invoiceDetail->invoice_id = $invoice->id;

                  // each product
                  $invoiceDetail->product_id = $request->product_id[$i];
                  $invoiceDetail->quantity = $request->product_quantity[$i];
                  if($request->product_amount_off[$i]){
                    $invoiceDetail->amount_off = $request->product_amount_off[$i];// does it need?
                  }
                //   $invoiceDetail->amount_off = $request->product_amount_off[$i];// does it need?
                  $invoiceDetail->selling_price = $request->selling_price[$i];
                  $invoiceDetail->line_total = $request->product_line_total[$i];

                  $invoiceDetail->status = '1';
                  $invoiceDetail->save();
               }

            }
        });
        $notification = array([
            'message'=>'Cập nhật hóa đơn thành công',
            'alert-type'=>'success'
        ]);
        // use the session to pass a message on the next request not the current one
        // When returning a view just pass the data directly
        return redirect()->route('invoices.index')->with(['message'=>'Cập nhật hóa đơn thành công',
        'alert-type'=>'success' ]);
        // return redirect()->route('invoices.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        // $invoice->delete();
        // $notification = [
        //     'message' => 'xóa hóa đơn thành công',
        //     'alert-type' =>'success'
        // ];
        // return redirect(route('admin.invoices.index'))->with($notification);
        echo ($invoice->id);
    }
    public function print(Request $request){
        $invoice = Invoice::findOrFail($request->invoiceId);
        $customer = $invoice->customer;
        $invoiceDetails = $invoice->invoiceDetails;
        $pdf = LaravelMpdf::loadView('app.invoice.print2', compact(['invoice','customer','invoiceDetails']));
        // use this package: https://github.com/mccarlosen/laravel-mpdf
        return $pdf->stream('document.pdf');
        // return view('app.invoice.print', compact(['invoice','customer','invoiceDetails']));
    }
    public function printMultipleInvoices(Request $request){
        $invoice = Invoice::findOrFail(11);
            // $customer = $invoice->customer;
            // $invoiceDetails = $invoice->invoiceDetails;
            // dd($request->all());
            // $invoices = Invoice::whereIn('id',$request->id)->with('products','customer','invoiceDetails')->get();
            // $invoices = Invoice::whereIn('id',$request->id);
            // dd($request->id);
            // Object.entries($request->id);
            // $ids = explode(',',$request->id);
            $ids = trim($request->id,'{}');
            $ids = explode(',',$ids);
            // dd($ids);
            $invoices = Invoice::whereIn('id',$ids)->with('products','customer','invoiceDetails')->get();
            // $invoices = Invoice::whereIn('id',$ids)->get()->count();


            // dd($invoices);

            $pdf = LaravelMpdf::loadView('app.invoice.print_multiple_invoices', compact('invoices'));
            return $pdf->stream('invoices.pdf');
        // dd($request->id);
    }


    public function ajaxDelete(Request $request){
        $invoice = Invoice::whereId($request->invoiceID)
        ->first();
        if($invoice->delete()){
            return response()->json(['message'=>'xóa hóa đơn thành công']);
        }
        return response()->json(['error'=>'some errors']);

    }
    public function deleted(){
        // dd('hihih');
        $invoices = Invoice::onlyTrashed()->get();
        return view('app.invoice.deleted', compact('invoices'));
    }
    // public function destroyPermanently(Request $request)
    // {
    //     $invoice = Invoice::onlyTrashed()
    //     ->whereId($request->invoiceID)
    //     ->first();

    //     $invoice->forceDelete();
    //     $notification = [
    //         'message' => 'Xóa hóa đơn thành công',
    //         'alert-type' =>'success'
    //     ];
    //     return redirect(route('admin.invoices.deleted'))->with($notification);
    // }
    // public function restore( Request $request)
    // {
    //     $invoice = Invoice::onlyTrashed()
    //     ->whereId($request->invoiceID)
    //     ->first();
    //     $invoice->restore();
    //     $notification = [
    //         'message' => 'khôi phục hóa đơn thành công',
    //         'alert-type' =>'success'
    //     ];
    //     return redirect(route('admin.invoices.deleted'))->with($notification);
    // }
    public function ajaxRestore( Request $request)
    {
        $invoice = Invoice::onlyTrashed()
        ->whereId($request->invoiceID)
        ->first();
        if($invoice->restore()){
            return response()->json(['message'=>'khoi phuc hoa don da xoa thanh cong']);
        }
        return response()->json(['error'=>'some errors']);
    }

    public function ajaxDestroyPermanently( Request $request)
    {
        $invoice = Invoice::onlyTrashed()
        ->whereId($request->invoiceID)
        ->first();
        if($invoice->forceDelete()){
            return response()->json(['message'=>'xóa vĩnh viễn hóa đơn thành công']);
        }
        return response()->json(['error'=>'some errors']);
    }

    public function ajaxSearchProduct(Request $request)
    {
        if( empty($request['term']) ){
            return false;
        }

        $key = $request['term'];

        $products = Product::where('name','like','%' .$key .'%')->limit(10)->get();
        if( !$products ){
            exit;
        }

        foreach($products as $product){
            $result[] =
                array(
                    'name' => $product->name,
                    'id'=>$product->id,
                    'price'=> $product->price,
                    'image'=> $product->getFirstImage(),

                    'SKU'=>$product->SKU,
                    'sale_unit'=>$product->sale_unit?$product->sale_unit:'',
                    //'SKU'=>$product->SKU,
                   // 'SKU'=>$product->SKU,


                );
        }

        return response()->json($result);
    }
    public function ajaxSearchCustomer(Request $request)
    {
        if( empty($request['term']) ){
            return false;
        }

        $key = $request['term'];
        if(is_numeric($key)){
            $customers = Customer::where('phone','like','%' .$key .'%')->with('addresses', 'addresses.zone:id,name,short_name,district_code', 'addresses.ward:code,name')->select('id','phone','name','address')->limit(10)->get();
        }else{
            $customers = Customer::where('name','like','%' .$key .'%')->with('addresses', 'addresses.zone:id,name,short_name,district_code', 'addresses.ward:code,name,district_code')->select('id','phone','name','address')->limit(10)->get();
        }
        if( !$customers ){
            exit;
        }

        return response()->json($customers);
    }
    public function ajaxCreateCustomer(Request $request){
       //$result = $request;
       $validated = $request->validate([
        'customerName' => 'required',
        'zoneId' => 'required',
        ]);
       $newCustomer = Customer::create([
        'name'=>$request->customerName,
        'phone'=>$request->customerPhone,
        'address'=>$request->customerAddress,
       ]);
       if( $newCustomer){
        // insert record into addresses table
        $newAddress = Address::create([
            'name'=>$request->address,
            'zone_id'=>$request->zoneId,
            'ward_code'=>$request->wardCode,

        ]);
        $newCustomer->addresses()->save($newAddress);

        return response()->json($newCustomer->load('addresses.zone','addresses.ward'));
       }

    }
    public function ajaxUpdateCustomer(Request $request){

        $customer = Customer::findOrFail($request->customerID);

        $updateCustomer = $customer->update([
         'name'=>$request->customerName,
         'phone'=>$request->customerPhone,
         'address'=>$request->customerAddress,
        ]);
        // update relationship
        if($customer->addresses->count()>0)
        {
            $address = $customer->addresses[0];
            $address->name= $request->address;
            $address->zone_id= $request->zoneId;
            $address->ward_code= $request->wardCode;
            $address->save();
        }else{// create new address
            $address = Address::create([
                'name'=>$request->address,
                'zone_id'=> $request->zoneId,
                'ward_code'=>$request->wardCode
            ]);
            // add relationship
            $address->customers()->save($customer);
        }
        if($updateCustomer){
         return response()->json(['message'=>'Cập nhật khách hàng thành công', 'customer'=>$customer->toArray()]);
        }
        return response()->json(['error','không thể cập nhật khách hàng']);

     }
     public function ajaxFilterDeletedInvoicesByDateRange(Request $request){
        //$startDate = date('Y-m-d',strtotime($request->start_date));
        $startDate = date('Y-m-d',strtotime($request->start_date));
        //$endDate = date('Y-m-d',strtotime($request->end_date));
        $endDate = date('Y-m-d',strtotime($request->end_date));
        $invoices = Invoice::onlyTrashed()  ->whereDate('deleted_at', '>=', $startDate)
                                            ->whereDate('deleted_at', '<=', $endDate)
                                            ->get();
        if($invoices->count()>0){

            $data = array();
            foreach($invoices as $invoice){
                $editedInvoice['date'] = date('d-m-Y',strtotime($invoice->deleted_at));
                $editedInvoice['invoice_no'] = $invoice->invoice_no;
                $editedInvoice['customer_name'] = $invoice->customer->name;
                $editedInvoice['customer_phone'] = $invoice->customer->phone;

                $editedInvoice['total'] = $invoice->total;
                $editedInvoice['note'] = $invoice->note;
                $editedInvoice['id'] = $invoice->id;

                array_push($data, $editedInvoice);

            } ;
            $output = array(
                // "draw"			=>	1,
                // "recordsTotal"	=>	$invoices->count(),
                // "recordsFiltered" => $invoices->count(),
                "data"			=>	$data
            );

            return response()->json($output);
        }

        return response()->json(['message'=>'no invoice']);
     }

     public function ajaxFilterInvoicesByDateRange(Request $request){
        $startDate = date('Y-m-d',strtotime($request->start_date));
        $endDate = date('Y-m-d',strtotime($request->end_date));
        $invoices = Invoice::whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate)->latest()->get();
        if($invoices->count()>0){

            $data = array();
            foreach($invoices as $invoice){
                // $editedInvoice['date'] = date('d-m-Y',strtotime($invoice->date));
                $editedInvoice['date'] = $invoice->date;
                $editedInvoice['invoice_no'] = $invoice->invoice_no;
                $editedInvoice['customer_name'] = $invoice->customer->name;
                $editedInvoice['customer_phone'] = $invoice->customer->phone;
                $editedInvoice['customer_address'] = $invoice->customer->address;

                $editedInvoice['total'] = $invoice->total;
                $editedInvoice['note'] = $invoice->note;
                $editedInvoice['id'] = $invoice->id;

                array_push($data, $editedInvoice);

            } ;
            $output = array(
                // "draw"			=>	1,
                // "recordsTotal"	=>	$invoices->count(),
                // "recordsFiltered" => $invoices->count(),
                "data"			=>	$data
            );

            return response()->json($output);
        }

        return response()->json(['message'=>'no invoice']);
     }
     public function ajaxSearchProvinces(Request $request){
        if( empty($request['term']) ){
            return false;
        }
        $key = $request['term'];

        $zones = Zone::where('name','like','%' .$key .'%')->limit(10)->get(['id','district_code','name','short_name']);
        if( !$zones ){
            exit;
        }
        // foreach($zones as $zone){
        //     $province = $zone->province->short_name;
        //     $district = $zone->district->short_name;
        //     $zone['short_name'] = $district .', '.$province;
        //     $zone->save();
        // }

        // $provinces = Province::with('districts:name')->get(['code','name']);
        // create new table zone and insert row like this
        return response()->json($zones);
     }
     public function ajaxGetWardsByZone(Request $request){
        if( empty($request['term']) ){
            return false;
        }
        $key = $request['term'];

        $wards = Ward::where('district_code','=',$request->districtCode)->where('name','like','%' .$key .'%')->limit(10)->get(['name','code']);
        if( !$wards ){
            exit;
        }

        return response()->json($wards);
     }

}
