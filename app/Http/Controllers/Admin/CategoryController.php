<?php

namespace App\Http\Controllers\Admin;


use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = Category::all();

       return view('admin.category.index', compact('data'));
    }
//category store
    public function store(Request $request){
       $validation = $request->validate([
        'category_name' => 'required|unique:categories|max:55'
       ]);

       Category::insert([
        'category_name' => $request->category_name,
         'category_slug' =>str::slug($request->category_name, '-')
       ]);


      // $notifi = array('message' => 'Category Inserted!', 'alert-type'=>'success');
    Toastr::success(' Category Insert Successfully!');
       return redirect()->back();
    }

    public function delete($id){
    $data = Category::find($id);
    $data->delete();
  Toastr::warning(' Category Delete Successfully!');
       return redirect()->back();

    }

    //edit
    public function edit($id){
      $data = Category::find($id);
      return response()->json($data);
    }
    //update
    public function update(Request $request){
       $data = Category::where('id', $request->id)->first();
       $data->update([
        'category_name'=>$request->category_name,
        'category_slug'=>str::slug($request->category_name, '-'),
       ]);

       Toastr::success(' Category Update Successfully!');
        return redirect()->back();

    }
}
