<?php

namespace App\Http\Controllers;

use App\transactions;
use Illuminate\Http\Request;

class userThings extends Controller
{
    public function addItemsToCartOrBuy(Request $request)
    {
    $userid = Auth::user()->id;
    $qty = $request->qty;
    $productid = $request->product_id;
    switch ($request->submitButton){
        case 'addtocart':
            carts::create([
                'user_id' => $userid,
                'product_id'=> $productid,
                'qty'=>$qty,
                'status'=>'notyet',
            ]);
            return back();
        break;
        case 'buy':
            return view('buyItems',compact('qty','productid'));
        break;
    }
    public function ifBuy(Request $request)
    {
        $productIdinIfBuy = $request->product_id;
        $QtyinIfBuy = $request->qty;
        transactions::create([
            'address'=>$request->address,
            'regency'=>$request->regency,
            'province'=>$request->province,
            
        ])
    }

    }
    public function userReviews()
    {

    }

}
