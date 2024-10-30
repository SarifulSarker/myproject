<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SendSmsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function byclass(){

           return view('admin.sendsms.byclass');
  }


public function individualpage(){
    $sms_lists = DB::table('sms_lists')->get();

    return view('admin.sendsms.byindividual', compact('sms_lists' ));
}

public function searchbyindividual(Request $request){
    $query = $request->input('searchindividual');
    $students = Student::where('student_id', 'LIKE', '%' . $query . '%')->get();

    // Pass the students data to the view
    $sms_lists = DB::table('sms_lists')->get();
    return view('admin.sendsms.byindividual', compact('students', 'sms_lists'));
}



public function byclasses(){
    $sms_lists = DB::table('sms_lists')->get();
    $classNames = Student::distinct('class')->pluck('class');

   // return view('your_view_name', ['classNames' => $classNames]);
    return view('admin.sendsms.byclasses', compact('classNames', 'sms_lists'));
}
public function getStudentsPhoneNumbers(Request $request)
{
    $className = $request->input('class');
    $phoneNumbers = Student::where('class', $className)->pluck('phone')->toArray();
    return response()->json(['phoneNumbers' => $phoneNumbers]);
}

public function searchbyclass(Request $request){
    $query = $request->input('searchbyclass'); // Ensure you're using the correct input name

    // Query the students table to find students with the matching class
    $students = Student::where('class', 'LIKE', '%' . $query . '%')->get();

    // Pass the students data to the view
    $sms_lists = DB::table('sms_lists')->get();
    return view('admin.sendsms.byclass', compact('students', 'sms_lists'));
}


}

