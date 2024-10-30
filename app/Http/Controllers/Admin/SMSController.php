<?php

namespace App\Http\Controllers\Admin;

use App\Models\sms_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SMSController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

       $data = DB::table('sms_lists')->get();

       return view('admin.sms.index', compact('data'));
    }

    public function inputform(){
        return view('admin.sms.store');
    }
    public function store(Request $request){


      // dd($request);
       $data = array(

        'sms_title' => $request->sms_title,

        'text' => $request->text,

        'status' => $request->status,


    );

   DB::table('sms_lists')->insert($data);
   return redirect()->route('sms.index');

     }

     public function delete($id){
        // Find the SMS record by ID
        $sms = DB::table('sms_lists')->where('id', $id)->first();

        // Check if the SMS record exists
        if($sms){
            // Delete the SMS record
            DB::table('sms_lists')->where('id', $id)->delete();
            // Redirect back with success message or any additional logic
            return redirect()->back();
        } else {
            // Redirect back with error message or any additional logic
            return redirect()->back();
        }
    }


    public function edit($id){
        $data = DB::table('sms_lists')->where('id', $id)->first();
       return view('admin.sms.edit', compact('data'));
      }


      public function update(Request $request){

       $data = DB::table('sms_lists')->where('id', $request->id);

        $data->update([
         'sms_title'=>$request->sms_title,
         'text'=>$request->text,
         'status'=>$request->status,
        ]);


        return redirect()->route('sms.index');

     }



}
