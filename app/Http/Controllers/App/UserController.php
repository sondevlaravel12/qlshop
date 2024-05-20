<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $users = User::with('roles')->get();
        $users = User::whereHas('roles', function (Builder $query) {
            $query->where('name', '!=', 'superadmin');
        })->get();

        return view('app.users.index', compact('users'));
    }

    public function ajaxChangeStatus(Request $request){
        $user = User::findOrFail($request->id);
        if($user){
            $user->status = $request->status;
            $user->save();
            $response = [
                'message'=>'cập nhật trạng thái user thành công',
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
        return view('user.create');
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

        if($user = User::create($input)){
            // link domain
            // if($domain = $request->domain){
            //     $fullnameDomain = $domain . '.' . $request->getHost();
            //     $user->domains()->create(['domain' => $fullnameDomain]);
            // }
            if($domain = $request->domain){
                $fullnameDomain = $domain . '.' . $request->getHost();
                $user->domains()->create(['domain' => $fullnameDomain]);
            }
            $notifycation = [
                'message' => 'Thêm mới User thành công',
                'alert-type' =>'success'
            ];

            return redirect()->route('users.index')->with($notifycation);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TenUserant $user)
    {
        return 'This is your multi-user application. The id of the current user is ' . $user->id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
    public function ajaxRemove(Request $request){
        $user = User::find($request->id);
        // soft delete
        if($user->delete()){
            $response = [
                'message'=>'softdelete user thành công',
                'alert-type'=>'success'
            ];
            return response()->json($response);
        }
    }
    public function offUser(){
        $offUsers = User::where('status','=','off')->get();
        return view('user_trashed', compact('offUsers'));
    }
    public function ajaxRemovePermanently(Request $request){
        $trashedUsers = User::findOrFail($request->id);
        if($trashedUsers->delete()){
            $response = [
                'message'=>'delete user thành công',
                'alert-type'=>'success'
            ];
            return response()->json($response);
        }

    }
    public function gotoUser(User $user){
        $userFullDomain = 'http://' . $user->domains()->first()->domain;
        // dd($userFullDomain);
        return redirect($userFullDomain);
    }
    // public function ajaxRestore(Request $request){
    //     $trashedUsers = User::onlyTrashed()->where('id','=',$request->id)->first();
    //     if($trashedUsers->restore()){
    //         $response = [
    //             'message'=>'restore user thành công',
    //             'alert-type'=>'success'
    //         ];
    //         return response()->json($response);
    //     }
    // }
    public function dashboard(){
        return view('user.dashboard');
    }
}
