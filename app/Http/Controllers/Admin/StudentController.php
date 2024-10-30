<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $data = DB::table('students')->get();

        return view('admin.student.index', compact('data'));
     }
     public function store(Request $request){
       $path = null;
       $filename = null;
        if($request->has('image')){

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $filename = time().'.'.$extension;

            $path = 'uploads/category/';
            $file->move($path, $filename);
        }



        Student::create([

            'name' => $request->name,
            'roll' => $request->roll,
            'student_id' => $request->student_id,
            'class' => $request->class,
            'session' => $request->session,
            'image' => $path.$filename,
            'phone' => $request->phone,

        ]);

       return redirect()->back();
     }
}
