<?php

namespace App\Http\Controllers;

use App\products;
use Illuminate\Http\Request;

class userProducts extends Controller
{
    public function showAllProducts(){
        $allProducts = products::all();
        return view('products',['products'=>$allProducts]);
    }
    public function showProducts($id){
        $products = products::find($id);
        return view('details.products',['products'=>$products]);
    }
}
