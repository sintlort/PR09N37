<?php

namespace App\Http\Controllers;

use App\product_categories;
use App\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $image = products::with('prodimage')->get();
        $allproducts = products::with('prodimage')->with('proddiscount')->with('detailCategory')->get();
        if(Auth::user())
        {
            $notification = Auth::user()->unreadNotifications;
            return view('home',compact('allproducts','image','notification'));
        }

        return view('home',compact('allproducts','image'));
    }
}
