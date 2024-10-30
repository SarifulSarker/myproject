<?php

namespace App\Http\Controllers\Admin;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WarehouseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
       if ($request->ajax()) {
            $data=DB::table('warehouses')->latest()->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal" ><i class="fas fa-edit"></i></a>
                        <a href="'.route('warehouse.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                        </a>';
                       return $actionbtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.warehouse.index');
    }

    //store method
    public function store(Request $request)
    {
        $validated = $request->validate([
           'warehouse_name' => 'required|unique:warehouses',
        ]);

        $data=array();
        $data['warehouse_name']=$request->warehouse_name;
        $data['warehouse_address']=$request->warehouse_address;
        $data['warehouse_phone']=$request->warehouse_phone;
        DB::table('warehouses')->insert($data);


    	Toastr::success(' Ware Insert Successfully!');
        return redirect()->back();
    }

    //delete warehouse
    public function delete($id)
    {
        DB::table('warehouses')->where('id',$id)->delete();


    	Toastr::success(' Category Delete Successfully!');
        return redirect()->back();

    }

    public function edit($id)
    {
        $warehouse=DB::table('warehouses')->where('id',$id)->first();
        return view('admin.warehouse.edit',compact('warehouse'));
    }

    public function update(Request $request)
    {
        $data=array();
        $data['warehouse_name']=$request->warehouse_name;
        $data['warehouse_address']=$request->warehouse_address;
        $data['warehouse_phone']=$request->warehouse_phone;
        DB::table('warehouses')->where('id',$request->id)->update($data);



    	Toastr::success(' Category Update Successfully!');
        return redirect()->back();
    }
}
