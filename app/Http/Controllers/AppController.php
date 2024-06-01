<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index(){
        // return redirect()->route('center.home');
        // return view('welcome');
        // dd('hi');
        return redirect()->route('tenants.index');
    }
}
