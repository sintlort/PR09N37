<?php

namespace App\Http\Controllers;

use App\discounts;
use App\product_categories;
use App\product_category_details;
use App\product_images;
use App\product_reviews;
use App\products;
use App\transactions;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class userProducts extends Controller
{

    public function showAllProducts(){
        $allProducts = products::with('prodimage')->with('proddiscount')->with('detailCategory')->get();
        return view('products',['products'=>$allProducts]);
    }
    public function showProducts($id){
        $products = products::where('id',$id)->first();
        $img = product_images::where('product_id',$id)->get();
        $discount = discounts::where('id_product',$id)->get();
        $review = product_reviews::where('product_id',$id)->with('user_rev')->get();
        $rate = product_reviews::where('product_id',$id)->avg('rate');
        $categorydetailproducts = product_category_details::where('product_id',$id)->with('checkCategory')->get();
        if(Auth::user())
        {
            $notification = Auth::user()->unreadNotifications;
            return view('detailsProducts',compact('products','discount','categorydetailproducts','img','notification','review','rate'));
        }
        return view('detailsProducts')->with(compact('products','discount','categorydetailproducts','img','review','rate'));
    }

    public function tester()
    {
        $items = transactions::all();

        return view('tester',compact('items','c'));
    }
}
