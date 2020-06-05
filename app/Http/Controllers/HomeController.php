<?php

namespace App\Http\Controllers;

use App\product_categories;
use App\products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $allproducts = products::all();
        $listcat = product_categories::all();
        $image = products::with('prodimage')->get();


        return view('home',compact('allproducts','listcat','image'));
    }
}
