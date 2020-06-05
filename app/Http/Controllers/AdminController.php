<?php

namespace App\Http\Controllers;
use App\discounts;
use App\product_categories;
use App\product_category_details;
use App\product_images;
use App\products;
use App\transactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        return view('admin');
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

    public function registerCategoryDetails(Request $request){

    }

    public function CategoryDetails(){
        $category = product_categories::all();
        return view('categoryDetails',['categories'=>$category]);
    }

    public function categoryEdit($id){
        $categoryid = product_categories::find($id);
        return view('editCategory',['categoryid'=>$categoryid]);
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
        return view('addProducts',['listcat'=>$listcat]);
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
        return view('showAdminProducts',compact('allproducts','listcat'));
    }

    public function editProducts($id)
    {
        $editproducts = products::find($id);
        $listcat = product_categories::all();
        return view('editProducts',compact('editproducts','listcat'));
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

        return view('discount',compact('productitems'));

    }

    public function addDiscountToProducts(Request $request)
    {
        $temporaryDiscountItems = new discounts([
            'percentage'=>$request->percent,
            'start'=>$request->datestart,
            'end'=>$request->dateend]);
        $productitem = products::find($request->id);
        $productitem->proddiscount()->save($temporaryDiscountItems);

        return redirect(route('discount.form'));
    }

    public function admin_transaction()
    {
        $items = transactions::all();
        return view('trans',compact('items'));
    }
    public function verifikasi($id)
    {
        $item = transactions::find($id);
        $item->status="verified";
        $item->save();
        return redirect(route('admin_transaction'));
    }
    public function delivered($id)
    {
        $item = transactions::find($id);
        $item->status="delivered";
        $item->save();
        return redirect(route('admin_transaction'));
    }
}
