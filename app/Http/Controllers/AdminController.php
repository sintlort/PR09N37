<?php

namespace App\Http\Controllers;
use App\Admins;
use App\carts;
use App\couriers;
use App\discounts;
use App\Notifications\SendNotification;
use App\Notifications\SendNotificationForAdmin;
use App\Notifications\SendNotificationResponseForAdmin;
use App\product_categories;
use App\product_category_details;
use App\product_images;
use App\product_reviews;
use App\products;
use App\response;
use App\transactions;
use App\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $perbulan = transactions::where('status','!=','expired')->where('status','!=','canceled')->avg('sub_total');
        $perbulangrafik = transactions::selectRaw('sum(sub_total) as total, month(created_at) as month')->groupBy('month')->get();
        $laporan = transactions::selectRaw('count(*) as jumlah, sum(sub_total) as sub_total, month(created_at) as month')->groupBy('month')->get();
        $tahunan = transactions::selectRaw('count(*) as jumlah, sum(sub_total) as sub_total, year(created_at) as year')->groupBy('year')->get();
        $json_total = [];
        $json_bulan = [];
        $datapenghasilan1 = 0;
        $datatahunan1=0;
        foreach($perbulangrafik as $grafik){
            $json_total[] = $grafik->total;
            $dateobj = DateTime::createFromFormat('!m',$grafik->month);
            $monthname = $dateobj->format('F');
            $json_bulan[] = $monthname;
        }
        foreach($laporan as $penghasilan){
            $datapenghasilan2 = $datapenghasilan1+$penghasilan->sub_total;
            $datapenghasilan1 = $datapenghasilan2;
        }
            $datapenghasilan3 =$datapenghasilan1/count($laporan);
        foreach ($tahunan as $pendapatantahunan){
            $datatahunan2 = $datatahunan1+$pendapatantahunan->sub_total;
            $datatahunan1 = $datatahunan2;
        }
            $datatahunan3 = $datatahunan1/count($tahunan);
        $notification = Auth::user()->unreadNotifications;
        return view('admin',compact('notification','perbulan','json_bulan','json_total','laporan','datapenghasilan3','datatahunan3'));
    }
    public function readcourier()
    {
        $courier = couriers::all();
        $notification = Auth::user()->unreadNotifications;
        return view('courier',compact('courier','notification'));
    }

    public function createcourier(Request $request)
    {
        $val = $request->validate([
            'courier_name'=>'required'
        ]);
        $courier = strtolower($request->courier_name);
        couriers::create([
            'courier'=>$courier,
        ]);
        return redirect(route('read_courier'));
    }

    public function updatecourier(Request $request)
    {
        $val = $request->validate([
            'courier_name'=>'required'
        ]);
        $courier = strtolower($request->courier_name);
        $updateCourier = couriers::find($request->id);
        $updateCourier->courier = $courier;
        $updateCourier->save();

        return redirect(route('read_courier'));

    }

    public function deletecourier($id)
    {
        $delcourier = couriers::find($id);
        $delcourier->delete();

        return redirect(route('read_courier'));
    }

    public function showRegisterCategory()
    {
        return view('category');
    }

    public function registerCategory(Request $request)
    {
        $val = $request->validate([
            'category_name'=>'required'
        ]);
        product_categories::create([
            'category_name'=>$request->category_name,
        ]);
        return redirect('/admin/category');
    }

    public function CategoryDetails(){
        $categories = product_categories::all();
        $notification = Auth::user()->unreadNotifications;
        return view('categoryDetails',compact('categories','notification'));
    }

    public function categoryEdit($id){
        $categoryid = product_categories::find($id);
        $notification = Auth::user()->unreadNotifications;
        return view('editCategory',compact('categoryid','notification'));
    }

    public function categoryUpdate(Request $request)
    {
        $val = $request->validate([
            'category_name'=>'required'
        ]);
        $updateCategory = product_categories::find($request->id);
        $updateCategory->category_name=($request->category_name);
        $updateCategory->save();
        return redirect(route('category.details'));
    }

    public function categoryDelete($id)
    {
        $deleteCategory = product_categories::find($id);
        $deleteCategory->delete();
        return redirect(route('category.details'));
    }

    public function showaddProducts()
    {
        $listcat = product_categories::all();
        $notification = Auth::user()->unreadNotifications;
        return view('addProducts',compact('listcat','notification'));
    }

    public function addProduct(Request $request)
    {
        $val = $request->validate([
            'product_name'=>'required',
            'product_price'=>'required',
            'product_description'=>'required',
            'product_stock'=>'required',
            'product_weight'=>'required',
        ]);
        if($request->hasfile('file')) {
            $product_image_path='product_images';
            $productid = products::create([
                'product_name' => $request->product_name,
                'price' => $request->product_price,
                'description'=> $request->product_description,
                'stock' => $request->product_stock,
                'weight'=> $request->product_weight,
            ]);
            $arrayCategory = $request->input('categories');
            foreach($arrayCategory as $ac){
                product_category_details::create([
                    'product_id'=>$productid->id,
                    'category_id'=>$ac,
                ]);
            }

            $file = $request->file('file');
            foreach($file as $files){
                $file_name = time()."_".$files->getClientOriginalName();
                $files->move(public_path().'/product_images/', $file_name);
                product_images::create([
                    'product_id' => $productid->id,
                    'image_name' => $file_name,
                ]);
            }
        }
        return redirect(route('admin.dashboard'));
    }

    public function showAllProducts()
    {
        $allproducts = products::all();
        $listcat = product_categories::all();
        $notification = Auth::user()->unreadNotifications;
        return view('showAdminProducts',compact('allproducts','listcat','notification'));
    }

    public function editProducts($id)
    {
        $editproducts = products::find($id);
        $listcat = product_categories::all();
        $notification = Auth::user()->unreadNotifications;
        return view('editProducts',compact('editproducts','listcat','notification'));
    }

    public function updateProducts(Request $request)
    {
        $val = $request->validate([
            'product_name'=>'required',
            'product_price'=>'required',
            'product_description'=>'required',
            'product_stock'=>'required',
            'product_weight'=>'required',
        ]);
        $updateProducts = products::find($request->product_id);
        $updateProducts->product_name = $request->product_name;
        $updateProducts->price = $request->product_price;
        $updateProducts->description = $request->product_description;
        $updateProducts->stock = $request->product_stock;
        $updateProducts->weight = $request->product_weight;
        $updateProducts->save();
        $updateDetailsCategory = product_category_details::where('product_id',$request->product_id)->first();
        $updateDetailsCategory->category_id = $request->categories;
        $updateDetailsCategory->save();
        return redirect(route('show.all.products'));
    }

    public function deleteProducts($id)
    {
        $deleteProducts = products::find($id);
        $deleteProducts->delete();
        return redirect(route('show.all.products'));
    }

    public function showAddDiscountForm()
    {
        $productitems=products::all();
        $notification = Auth::user()->unreadNotifications;
        return view('discount',compact('productitems','notification'));

    }

    public function showDiscount()
    {
        $disc = discounts::with('relasiDiskonProduct')->get();
        $productitems = products::all();
        $notification = Auth::user()->unreadNotifications;
        return view('showDiscount',compact('productitems','disc','notification'));
    }

    public function deleteDiscount($id)
    {
        $deletediscount = discounts::find($id);
        $deletediscount->delete();
        return redirect(route('show_discount'));
    }

    public function updateDiscount(Request $request)
    {
        $val = $request->validate([
            'percent'=>'required',
            'datestart'=>'required',
            'dateend'=>'required',
        ]);
        $update = discounts::find($request->id);
        $update->percentage = $request->percent;
        $update->start = $request->datestart;
        $update->end = $request->dateend;
        $update->id_product = $request->id_product;
        $update->save();
        return redirect(route('show_discount'));
    }

    public function addDiscountToProducts(Request $request)
    {
        $val = $request->validate([
            'percentage'=>'required',
            'start'=>'required',
            'end'=>'required',
        ]);
        $temporaryDiscountItems = new discounts([
            'percentage'=>$request->percent,
            'start'=>$request->datestart,
            'end'=>$request->dateend]);
        $productitem = products::find($request->id);
        $productitem->proddiscount()->save($temporaryDiscountItems);
        return redirect(route('show_discount'));
    }

    public function admin_transaction()
    {
        $items = transactions::all();
        $notification = Auth::user()->unreadNotifications;
        return view('trans',compact('items','notification'));
    }
    public function verifikasi($id)
    {
        $item = transactions::find($id);
        $item->status="verified";
        $item->save();
        $user_data = User::find($item->user_id);
        $reason = "Verifikasi";
        $admin = Auth::user();
        Notification::send($user_data, new SendNotificationForAdmin($reason, $admin));
        return redirect(route('admin_transaction'));
    }
    public function delivered($id)
    {
        $item = transactions::find($id);
        $item->status="delivered";
        $item->save();
        $user_data = User::find($item->user_id);
        $reason = "Pengiriman";
        $admin = Auth::user();
        Notification::send($user_data, new SendNotificationForAdmin($reason, $admin));
        return redirect(route('admin_transaction'));
    }

    public function testid()
    {
        $cart = carts::where('user_id',2)->where('status',"notyet")->with('procarts')->get();

        $weight = 0;
        for($i=0;$i<=($cart->count()-1);$i++){
            $weight = $weight+($cart->get($i)->procarts->weight);
        }

        $notification = Auth::user()->unreadNotifications;
        $proddisc = products::find(32)->with('proddiscount');
        dd($proddisc);
        return view('tester',compact('weight','notification'));
    }

    public function show_all_reviews()
    {
        $rev = product_reviews::has('product_rev')->has('user_rev')->get();
        $notification = Auth::user()->unreadNotifications;
        return view('response',compact('rev','notification'));
    }

    public function respond_to_reviews(Request $request)
    {
        $val = $request->validate([
            'respon'=>'required',
        ]);
        $admin_id = Auth::id();
        $review_id = $request->id_review;
        $konten = $request->respon;
        $rev = response::create([
            'review_id'=>$review_id,
            'admin_id'=>$admin_id,
            'content'=>$konten,
        ]);
        $beforeRev = product_reviews::find($rev->review_id);
        $user_data = User::find($beforeRev->user_id);
        $reason = "Respond";
        $admin = Auth::user();
        Notification::send($user_data, new SendNotificationResponseForAdmin($reason, $admin));
        return redirect(route('show_all_reviews'));
    }
}
