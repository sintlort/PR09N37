<?php

namespace App\Http\Controllers;

use App\product_categories;
use App\product_category_details;
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
        $categorydetailproducts = product_category_details::where('product_id',$id)->first();
        $idcategory = $categorydetailproducts->category_id;
        $catproducts = product_categories::find($idcategory);
        return view('detailsProducts')->with(compact('products','catproducts'));
    }
}
