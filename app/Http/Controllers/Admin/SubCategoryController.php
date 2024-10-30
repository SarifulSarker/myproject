<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;

use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    // index method for read data
    public function index(){
        $data=Subcategory::all();
        $category = Category::all();
       return view('admin.subcategory.index', compact('data', 'category'));
    }

    //sub category store
    public function store(Request $request)
    {
    	$validated = $request->validate([
           'subcategory_name' => 'required|max:55',
       ]);


       Subcategory::insert([
        'category_id'=> $request->category_id,
        'subcategory_name'=> $request->subcategory_name,
        'subcat_slug'=> Str::slug($request->subcategory_name, '-')
    ]);



    	Toastr::success(' Category Insert Successfully!');
       return redirect()->back();

    }


    public function delete($id)
    {
    	// DB::table('subcategories')->where('id',$id)->delete();    //query builder

    	$subcat=Subcategory::find($id);
    	$subcat->delete();


    	Toastr::success(' SubCategory Insert Successfully!');
       return redirect()->back();


    }
    public function edit($id)
    {

    	$data=Subcategory::find($id);
    	$category=DB::table('categories')->get();

    	return view('admin.subcategory.edit',compact('data','category'));
    }

    public function update(Request $request)
    {
       //Eloquent ORM
       $subcategory=Subcategory::where('id',$request->id)->first();
       $subcategory->update([
       		'category_id'=> $request->category_id,
    		'subcategory_name'=> $request->subcategory_name,
    		'subcat_slug'=> Str::slug($request->subcategory_name, '-')
       ]);


       Toastr::success(' SubCategory update Successfully!');
       return redirect()->back();

    }
}
