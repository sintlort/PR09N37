<?php

namespace App\Http\Controllers;

use App\carts;
use App\couriers;
use App\product_images;
use App\products;
use App\transaction_details;
use App\transactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userThings extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function itemsAction(Request $request)
    {
        $userid = Auth::id();
        $qty = $request->qty;
        $product_id = $request->product_id;
        $products = products::find($product_id)->first();
        $prodimage = product_images::where('product_id',$product_id)->first();
        $kurir = couriers::all();
        $prov = $this->get_province();
        switch ($request->input('action')) {
            case 'buy':
                return view('buyitems',compact('userid','qty','product_id','products','kurir','prodimage','prov'));
                break;

            case 'cart':
                carts::create([
                    'user_id'=>$userid,
                    'product_id'=>$product_id,
                    'qty'=>$qty,
                    'status'=>"notyet",
                ]);
                $cart = carts::where('user_id',$userid)->where('status',"notyet")->with('procarts')->get();
                return redirect()->back()->with('alert','Success!!');
                break;
        }
    }

    /**
     * CONTROLLER TO POST USER'S ITEMS
     */
    public function buyItems(Request $request)
    {
        $stats = "unverified";
        $courier_id = couriers::where('courier',$request->kurir)->first();
        $prod_price = products::find($request->product_id);
        $trans = transactions::create([
            'timeout'=>Carbon::now()->addDays(1),
            'address'=>$request->address,
            'regency'=>$request->kota_id,
            'province'=>$request->provinsi_id,
            'total'=>$prod_price->price,
            'shipping_cost'=>$request->ongkosin,
            'sub_total'=>$request->totalin,
            'user_id'=>Auth::id(),
            'courier_id'=>$courier_id->id,
            'status'=>$stats,
        ]);
        $trans_details = transaction_details::create([
            'transaction_id'=>$trans->id,
            'product_id'=>$prod_price->id,
            'qty'=>$request->qty,
        ]);
        return redirect('home');
    }

    public function buyCarts()
    {
        $stats = "unverified";
        $courier_id = couriers::where('courier',$request->kurir)->first();
    }




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
    }
    public function data_transaction()
    {
        $user = Auth::id();
        $items = transactions::where('user_id',$user)->get();
        return view('trans',compact('items'));
    }

    public function proof_of_payment(Request $request)
    {
        if($request->hasFile('file')){
            $pop_path = '/proof/';
            $file = $request->file('file');
            $file_name = time()."_".$file->getClientOriginalName();
            $file->move(public_path().$pop_path, $file_name);
            $transaction = transactions::find($request->id_proof)->first();
            $transaction->proof_of_payment=$file_name;
            $transaction->save();
            return redirect(route('transaction_data'));
        };
    }

    public function cancel_transaction($id)
    {
        $trans = transactions::find($id);
        $trans->status="canceled";
        $trans->save();
        return redirect(route('transaction_data'));
    }

    /**
     * TO GET CITY
     * @param $key
     * @return array
     */
    public function get_city($id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?&province=$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e304c8fbe2f43ee05550b29695c56154"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response=json_decode($response,true);
            $data_kota = $response['rajaongkir']['results'];
            return json_encode($data_kota);
        }
    }

    /**
     * TO GET PROVINCE
     * @param $key
     * @return array
     */
    public function get_province(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e304c8fbe2f43ee05550b29695c56154"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response=json_decode($response,true);
            $data_pengirim = $response['rajaongkir']['results'];
            return $data_pengirim;
        }
    }

    public function couriercost($asal, $tujuan, $berat, $courier){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$asal&destination=$tujuan&weight=$berat&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: e304c8fbe2f43ee05550b29695c56154"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response=json_decode($response,true);
            $data_ongkir = $response['rajaongkir']['results'];
            return json_encode($data_ongkir);
        }
    }
}
