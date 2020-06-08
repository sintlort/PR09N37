<?php

namespace App\Http\Controllers;
use App\Admins;
use App\carts;
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
        $notification = Auth::user()->unreadNotifications;
        return view('admin',compact('notification'));
    }

    public function showRegisterCategory()
    {
        return view('category');
    }

    public function registerCategory(Request $request)
    {
        DB::table('product_categories')->insert([
            'category_name' => $request->category_name,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
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
        if($request->hasfile('file')) {
            $product_image_path='product_images';
            $productid = products::create([
                'product_name' => $request->product_name,
                'price' => $request->product_price,
                'description'=> $request->product_description,
                'stock' => $request->product_stock,
                'weight'=> $request->product_weight,
            ]);

            $details_category = product_category_details::create([
                'product_id'=>$productid->id,
                'category_id'=>$request->categories,
            ]);


            $file = $request->file('file');
            $file_name = time()."_".$file->getClientOriginalName();
            $file->move(public_path().'/product_images/', $file_name);
            product_images::create([
                'product_id' => $productid->id,
                'image_name' => $file_name,
            ]);
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
        $discount = discounts::with('discount')->get();
        dd($discount);
        return view('tester',compact('weight','notification','discount'));
    }

    public function show_all_reviews()
    {
        $rev = product_reviews::has('product_rev')->has('user_rev')->get();
        $notification = Auth::user()->unreadNotifications;
        return view('response',compact('rev','notification'));
    }

    public function respond_to_reviews(Request $request)
    {
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
