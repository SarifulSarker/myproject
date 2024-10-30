<?php

namespace App\Http\Controllers\Admin;

use DB;
use File;
use Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Auth;
use DataTables;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
//$data=Product::latest()->get();
            $imgurl='/files/product';

            $product="";
            $query=DB::table('products')->join('categories','products.category_id','categories.id')
                  ->join('subcategories','products.subcategory_id','subcategories.id')
                  ->join('brands','products.brand_id','brands.id');

              if ($request->category_id) {
                  $query->where('products.category_id',$request->category_id);
               }

              if ($request->brand_id) {
                  $query->where('products.brand_id',$request->brand_id);
              }

              if ($request->warehouse) {
                  $query->where('products.warehouse',$request->warehouse);
              }

              if ($request->status==1) {
                  $query->where('products.status',1);
              }
              if ($request->status==0) {
                  $query->where('products.status',0);
              }

          $product=$query->select('products.*','categories.category_name','subcategories.subcategory_name','brands.brand_name')
                  ->get();
    		return DataTables::of($product)
    				->addIndexColumn()

                    ->editColumn('thumbnail',function($row) use ($imgurl){
                        return '<img src="'.$imgurl.'/'.$row->thumbnail.'"  height="30" width="30" >';
                    })
                    // ->editColumn('category_name', function($row){
                    //     return $row->category->category_name;
                    // })
                    // ->editColumn('subcategory_name', function($row){
                    //     return $row->subcategory->subcategory_name;
                    // })
                    // ->editColumn('brand_name', function($row){
                    //     return $row->brand->brand_name;
                    // })
                    ->editColumn('featured',function($row){
                        if ($row->featured==1) {
                            return '<a href="#" data-id="'.$row->id.'" class="deactive_featurd"><i class="fas fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span> </a>';
                        }else{
                            return '<a href="#" data-id="'.$row->id.'" class="active_featurd"> <i class="fas fa-thumbs-up text-success"></i> <span class="badge badge-danger">deactive</span> </a>';
                        }
                    })

                    ->editColumn('today_deal',function($row){
                        if ($row->today_deal==1) {
                            return '<a href="#" data-id="'.$row->id.'" class="deactive_deal"><i class="fas fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span> </a>';
                        }else{
                            return '<a href="#" data-id="'.$row->id.'" class="active_deal"> <i class="fas fa-thumbs-up text-success"></i> <span class="badge badge-danger">deactive</span> </a>';
                        }
                    })
                    ->editColumn('status',function($row){
                        if ($row->status==1) {
                            return '<a href="#" data-id="'.$row->id.'" class="deactive_status"><i class="fas fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span> </a>';
                        }else{
                            return '<a href="#" data-id="'.$row->id.'" class="active_status"> <i class="fas fa-thumbs-up text-success"></i> <span class="badge badge-danger">deactive</span> </a>';
                        }
                    })
                    ->addColumn('action', function($row){
                        $actionbtn='
                        <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                        <a href="'.route('product.edit',[$row->id]).'" class="btn btn-info btn-sm edit"><i class="fas fa-edit"></i></a>
                        <a href="'.route('product.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                        </a>';
                       return $actionbtn;
                    })
    				->rawColumns(['action', 'thumbnail', 'featured', 'today_deal', 'status'])
    				->make(true);
    	}

        $category=DB::table('categories')->get();
        $brand=DB::table('brands')->get();
        $warehouses=DB::table('warehouses')->get();
        return view('admin.product.index',compact('category','brand','warehouses'));
    }

    public function store(Request $request)
    {


       $subcategory=DB::table('subcategories')->where('id',$request->subcategory_id)->first();
       $slug=Str::slug($request->name, '-');


       $data=array();
       $data['name']=$request->name;
       $data['slug']=Str::slug($request->name, '-');
       $data['code']=$request->code;
       $data['category_id']=$subcategory->category_id;
       $data['subcategory_id']=$request->subcategory_id;
       $data['childcategory_id']=$request->childcategory_id;
       $data['brand_id']=$request->brand_id;
       $data['pickup_point_id']=$request->pickup_point_id;
       $data['unit']=$request->unit;
       $data['tags']=$request->tags;
       $data['purchase_price']=$request->purchase_price;
       $data['selling_price']=$request->selling_price;
       $data['discount_price']=$request->discount_price;
       $data['warehouse']=$request->warehouse;
       $data['stock_quantity']=$request->stock_quantity;
       $data['color']=$request->color;
       $data['size']=$request->size;
       $data['description']=$request->description;
       $data['video']=$request->video;
       $data['featured']=$request->featured;
       $data['today_deal']=$request->today_deal;
       $data['product_slider']=$request->product_slider;
       $data['status']=$request->status;
       $data['trendy']=$request->trendy;
       $data['admin_id']=Auth::id();
       $data['date']=date('d-m-Y');
       $data['month']=date('F');

       //single thumbnail
       if ($request->thumbnail) {
             $thumbnail=$request->thumbnail;
             $photoname=$slug.'.'.$thumbnail->getClientOriginalExtension();
             Image::make($thumbnail)->resize(600,600)->save('files/product/'.$photoname);
             $data['thumbnail']=$photoname;   // public/files/product/plus-point.jpg
       }

       //multiple images
       $images = array();
       if($request->hasFile('images')){
           foreach ($request->file('images') as $key => $image) {
               $imageName= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
               Image::make($image)->resize(600,600)->save('files/product/'.$imageName);
               array_push($images, $imageName);
           }
           $data['images'] = json_encode($images);
       }

       DB::table('products')->insert($data);
       Toastr::success(' Product insert Successfully!');
       return redirect()->back();

    }

    public function create()
    {
        $category=DB::table('categories')->get();  // Category::all();
        $brand=DB::table('brands')->get();          // Brand::all();
        $pickup_point=DB::table('pickup_point')->get();  // Pickuppoint::all();
        $warehouse=DB::table('warehouses')->get();  // Warehouse::all();

        return view('admin.product.create',compact('category','brand','pickup_point','warehouse'));
    }


    public function getchildcategory($id)  //subcategory_id
    {
        $data=DB::table('childcategories')->where('subcategory_id',$id)->get();
        return response()->json($data);
    }


     //not featured
     public function notfeatured($id)
     {
         DB::table('products')->where('id',$id)->update(['featured'=>0]);
         return response()->json('Product Not Featured');
     }
      //active featured
    public function activefeatured($id)
    {
        DB::table('products')->where('id',$id)->update(['featured'=>1]);
        return response()->json('Product Featured Activated');
    }


     //not Deal
     public function notdeal($id)
     {
         DB::table('products')->where('id',$id)->update(['today_deal'=>0]);
         return response()->json('Product Not Today deal');
     }

     //active Deal
     public function activedeal($id)
     {
         DB::table('products')->where('id',$id)->update(['today_deal'=>1]);
         return response()->json('Product today deal Activated');
     }

     //not status
     public function notstatus($id)
     {
         DB::table('products')->where('id',$id)->update(['status'=>0]);
         return response()->json('Product Deactive');
     }

     //active staus
     public function activestatus($id)
     {
         DB::table('products')->where('id',$id)->update(['status'=>1]);
         return response()->json('Product Activated');
     }


}
