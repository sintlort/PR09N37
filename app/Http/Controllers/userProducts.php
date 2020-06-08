<?php

namespace App\Http\Controllers;

use App\product_categories;
use App\product_category_details;
use App\product_images;
use App\products;
use App\transactions;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class userProducts extends Controller
{

    public function showAllProducts(){
        $allProducts = products::all();
        return view('products',['products'=>$allProducts]);
    }
    public function showProducts($id){
        $products = products::find($id);
        $proddisc = products::find($id)->proddiscount;
        $prodimg = product_images::where('product_id',$id)->first();
        $categorydetailproducts = product_category_details::where('product_id',$id)->first();
        $idcategory = $categorydetailproducts->category_id;
        $catproducts = product_categories::find($idcategory);
        $notification = Auth::user()->unreadNotifications;
        return view('detailsProducts')->with(compact('products','catproducts','proddisc','prodimg','notification'));
    }

    public function tester()
    {
        $items = transactions::all();

        return view('tester',compact('items','c'));
    }
}
