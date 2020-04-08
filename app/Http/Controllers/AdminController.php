<?php

namespace App\Http\Controllers;
use App\product_categories;
use App\products;
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
        return redirect('/admin');
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
        return view('addProducts');
    }
    public function addProduct(Request $request)
    {
        products::create([
            'product_name' => $request->product_name,
            'price' => $request->product_price,
            'description'=> $request->product_description,
            'stock' => $request->product_stock,
            'weight'=> $request->product_weight,
        ]);
        return redirect(route('admin.dashboard'));
    }
}
