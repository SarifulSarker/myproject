<?php

namespace App\Http\Controllers\Admin;

use DB;
use File;
use PDF;
use Image;
use DataTables;
use App\Models\Brand;


use Barryvdh\DomPDF\Facade;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if ($request->ajax()) {
    		$data=DB::table('brands')->get();
        // $data = Brand::all();
    		return DataTables::of($data)
    				->addIndexColumn()
                    ->editColumn('front_page',function($row){
                        if ($row->front_page==1) {
                            return '<span class="badge badge-success">Home Page</span>';
                        }
                    })
    				->addColumn('action', function($row){
    					$actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal" ><i class="fas fa-edit"></i></a>
                      	<a href="'.route('brand.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                      	</a>';
                       return $actionbtn;
    				})
                    ->addColumn('checkbox', function($row){
                        $checkboxbtn = '<input type="checkbox" name="selected[]" class="users_checkbox" value="' . $row->id . '" />';
                        return $checkboxbtn;
                    })
    				->rawColumns(['action','front_page','checkbox'])
    				->make(true);
    	}

    	return view('admin.Brands.index');
    }

    //store method
    public function store(Request $request)
    {
    	$validated = $request->validate([
           'brand_name' => 'required|unique:brands|max:55',
        ]);

    	$slug=Str::slug($request->brand_name, '-');

    	$data=array();
    	$data['brand_name']=$request->brand_name;
    	$data['brand_slug']=Str::slug($request->brand_name, '-');
        $data['front_page']=$request->front_page;
    	 //working with image
    	  $photo=$request->brand_logo;
    	  $photoname=uniqid().'.'.$photo->getClientOriginalExtension();
    	  // $photo->move('public/files/brand/',$photoname);  //without image intervention
Image::make($photo)->resize(240,120)->save('files/brand/'.$photoname);  //image intervention
    	$data['brand_logo']='files/brand/'.$photoname;   // public/files/brand/plus-point.jpg
    	DB::table('brands')->insert($data);
        Toastr::success(' Category Insert Successfully!');
        return redirect()->back();
    }

    public function delete($id)
    {
    	$data=DB::table('brands')->where('id',$id)->first();
    	$image=$data->brand_logo;

    	if (File::exists($image)) {
    		 unlink($image);
    	}
    	DB::table('brands')->where('id',$id)->delete();
        Toastr::success(' Category delete Successfully!');
        return redirect()->back();

    }

    public function edit($id)
    {
    	$data=DB::table('brands')->where('id',$id)->first();
    	return view('admin.Brands.edit',compact('data'));
    }

    public function update(Request $request)
    {
    	$slug=Str::slug($request->brand_name, '-');
    	$data=array();
    	$data['brand_name']=$request->brand_name;
    	$data['brand_slug']=Str::slug($request->brand_name, '-');
        $data['front_page']=$request->front_page;
    	if ($request->brand_logo) {
    		  if (File::exists($request->old_logo)) {
    		         unlink($request->old_logo);
    	        }
    		  $photo=$request->brand_logo;
    	      $photoname=uniqid().'.'.$photo->getClientOriginalExtension();
    	      Image::make($photo)->resize(240,120)->save('files/brand/'.$photoname);
    	      $data['brand_logo']='files/brand/'.$photoname;
    	      DB::table('brands')->where('id',$request->id)->update($data);
    	     
    	}else{
		  $data['brand_logo']=$request->old_logo;
	      DB::table('brands')->where('id',$request->id)->update($data);

    	}
        Toastr::success(' Category Update Successfully!');
        return redirect()->back();
    }

    public function brandpdf(){
         $data = Brand::all();
         $pdf = PDF::loadView('admin.Brands.index-pdf', array('data' => $data) );
        return  $pdf->stream();
        //return view('admin.Brands.index-pdf', compact('data'));


    }

    public function removeall(Request $request){
        //dd($request);
        $user_id_array = $request->input('id');
        $user = Brand::whereIn('id', $user_id_array);
        if($user->delete())
        {
            echo 'Data Deleted';
        }
    }


}
