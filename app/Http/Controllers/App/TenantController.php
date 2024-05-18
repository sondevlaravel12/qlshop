<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::all();
        return view('index', compact('tenants'));
    }

    public function ajaxChangeStatus(Request $request){
        $tenant = Tenant::findOrFail($request->id);
        if($tenant){
            $tenant->status = $request->status;
            $tenant->save();
            $response = [
                'message'=>'cập nhật trạng thái tenant thành công',
                'alert-type'=>'success',
            ];
            return response()->json($response);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|min:2|max:50',
            // 'domain' => 'required|min:2|max:255',
            // 'expiry' => 'required',
        ]);
        $input = $request->except(['domain']);

        if($tenant = Tenant::create($input)){
            // link domain
            // if($domain = $request->domain){
            //     $fullnameDomain = $domain . '.' . $request->getHost();
            //     $tenant->domains()->create(['domain' => $fullnameDomain]);
            // }
            if($domain = $request->domain){
                $fullnameDomain = $domain . '.' . $request->getHost();
                $tenant->domains()->create(['domain' => $fullnameDomain]);
            }
            $notifycation = [
                'message' => 'Thêm mới Tenant thành công',
                'alert-type' =>'success'
            ];

            return redirect()->route('tenants.index')->with($notifycation);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        return 'This is your multi-tenant application. The id of the current tenant is ' . $tenant->id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
    public function ajaxRemove(Request $request){
        $tenant = Tenant::find($request->id);
        // soft delete
        if($tenant->delete()){
            $response = [
                'message'=>'softdelete tenant thành công',
                'alert-type'=>'success'
            ];
            return response()->json($response);
        }
    }
    public function offTenant(){
        $offTenants = Tenant::where('status','=','off')->get();
        return view('tenant_trashed', compact('offTenants'));
    }
    public function ajaxRemovePermanently(Request $request){
        $trashedTenants = Tenant::findOrFail($request->id);
        if($trashedTenants->delete()){
            $response = [
                'message'=>'delete tenant thành công',
                'alert-type'=>'success'
            ];
            return response()->json($response);
        }

    }
    public function gotoTenant(Tenant $tenant){
        $tenantFullDomain = 'http://' . $tenant->domains()->first()->domain;
        // dd($tenantFullDomain);
        return redirect($tenantFullDomain);
    }
    // public function ajaxRestore(Request $request){
    //     $trashedTenants = Tenant::onlyTrashed()->where('id','=',$request->id)->first();
    //     if($trashedTenants->restore()){
    //         $response = [
    //             'message'=>'restore tenant thành công',
    //             'alert-type'=>'success'
    //         ];
    //         return response()->json($response);
    //     }
    // }
    public function dashboard(){
        return view('tenant.dashboard');
    }
}
