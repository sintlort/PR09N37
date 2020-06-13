<?php

namespace App\Http\Controllers;

use App\Admins;
use App\carts;
use App\couriers;
use App\Notifications\SendNotification;
use App\Notifications\SendNotificationReview;
use App\product_images;
use App\product_reviews;
use App\products;
use App\transaction_details;
use App\transactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class userThings extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function itemsAction(Request $request)
    {
        $val = $request->validate([
            'qty'=>'required',
        ]);
        $userid = Auth::id();
        $qty = $request->qty;
        $product_id = $request->product_id;
        $products = products::find($product_id);
        $prodimage = product_images::where('product_id',$product_id)->first();
        $kurir = couriers::all();
        $prov = $this->get_province();
        $notification = Auth::user()->unreadNotifications;
        switch ($request->input('action')) {
            case 'buy':
                return view('buyitems',compact('userid','qty','product_id','products','kurir','prodimage','prov','notification'));
                break;

            case 'cart':
                carts::create([
                    'user_id'=>$userid,
                    'product_id'=>$product_id,
                    'qty'=>$qty,
                    'status'=>"notyet",
                ]);
                $cart = carts::where('user_id',$userid)->where('status',"notyet")->with('procarts')->get();
                return redirect()->back()->with('alert','Add to Cart Success!!');
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
            'selling_price'=>$prod_price->price,
        ]);
        $user_data = Auth::user();
        $reason = "Transaksi";
        $admin = Admins::find(1);
        Notification::send($admin, new SendNotification($reason, $user_data));
        return redirect(route('transaction_data'));
    }

    public function show_carts()
    {
        $userid = Auth::id();
        $kurir = couriers::all();
        $prov = $this->get_province();
        $cart = carts::where('user_id',$userid)->where('status',"notyet")->with('procarts')->get();
        $count = count($cart);
        if($count!=0){
            $weight=0;
            for($i=0;$i<=($cart->count()-1);$i++){
                $weight = $weight+($cart->get($i)->procarts->weight);
            }
            $price = 0;
            for($i=0;$i<=($cart->count()-1);$i++){
                $price = $price+($cart->get($i)->procarts->price);
            }
            $notification = Auth::user()->unreadNotifications;
            return view('cart',compact('userid','kurir','prov','cart','weight','price','notification'));
        }
        else
        {
            return redirect()->back();
        }

    }

    public function buy_cart_items(Request $request)
    {
        $val = $request->validate([
            'address'=>'required',
            'kota_id'=>'required',
            'provinsi_id'=>'required',
            'price'=>'required',
            'ongkosin'=>'required',
            'totalin'=>'required',
        ]);

        $stats = "unverified";
        $courier_id = couriers::where('courier',$request->kurir)->first();
        $prod_price = $request->price;
        $trans = transactions::create([
            'timeout'=>Carbon::now()->addDays(1),
            'address'=>$request->address,
            'regency'=>$request->kota_id,
            'province'=>$request->provinsi_id,
            'total'=>$prod_price,
            'shipping_cost'=>$request->ongkosin,
            'sub_total'=>$request->totalin,
            'user_id'=>Auth::id(),
            'courier_id'=>$courier_id->id,
            'status'=>$stats,
        ]);
        $cart = carts::where('user_id',Auth::id())->where('status',"notyet")->with('procarts')->get();
        for($i=0;$i<=($cart->count()-1);$i++){
            $prod_id = $cart->get($i)->procarts->id;
            $detail_product = products::find($prod_id);
            transaction_details::create([
                'transaction_id'=>$trans->id,
                'product_id'=>$prod_id,
                'qty'=>$cart->get($i)->qty,
                'selling_price'=>$detail_product->price,
            ]);
            $cartid = $cart->get($i)->id;
            $updatecart = carts::find($cartid);
            $updatecart->status="checkedout";
            $updatecart->save();
        }
        $user_data = Auth::user();
        $reason = "Transaksi";
        $admin = Admins::find(1);
        Notification::send($admin, new SendNotification($reason, $user_data));
        return redirect(route('transaction_data'));
    }

    public function data_transaction()
    {
        $user = Auth::id();
        $items = transactions::where('user_id',$user)->get();
        $notification = Auth::user()->unreadNotifications;
        return view('trans',compact('items','notification'));
    }

    public function proof_of_payment(Request $request)
    {
        if($request->hasFile('file')){
            $pop_path = '/proof/';
            $file = $request->file('file');
            $file_name = time()."_".$file->getClientOriginalName();
            $file->move(public_path().$pop_path, $file_name);
            $transaction = transactions::find($request->id_proof);
            $transaction->proof_of_payment=$file_name;
            $transaction->save();
            $user_data = Auth::user();
            $reason = "Upload bukti";
            $admin = Admins::find(1);
            Notification::send($admin, new SendNotification($reason, $user_data));
            return redirect(route('transaction_data'));
        };
    }

    public function cancel_transaction($id)
    {
        $trans = transactions::find($id);
        $trans->status="canceled";
        $trans->save();
        $user_data = Auth::user();
        $reason = "Cancel Transaksi";
        $admin = Admins::find(1);
        Notification::send($admin, new SendNotification($reason, $user_data));
        return redirect(route('transaction_data'));
    }

    public function show_review($id)
    {
        $items = transaction_details::where('transaction_id',$id)->with('inverseProduct')->get();
        $notification = Auth::user()->unreadNotifications;
        return view('review',compact('items','notification'));
    }

    public function post_review(Request $request)
    {
        $val = $request->validate([
            'rate'=>'required',
            'konten'=>'required'
        ]);
        $item_id = $request->id_product_review;
        $konten = $request->konten;
        $user = Auth::id();
        $ratings = $request->rate;
        $rev = product_reviews::create([
            'product_id'=>$item_id,
            'user_id'=>$user,
            'rate'=>$ratings,
            'content'=>$konten,
        ]);
        $user_data = Auth::user();
        $reason = "Review";
        $admin = Admins::find(1);
        Notification::send($admin, new SendNotificationReview($reason, $user_data));
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
