<?php

namespace App\Http\Controllers;
use App\product_categories;
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
        $categoryid = product_categories::
    }

}
