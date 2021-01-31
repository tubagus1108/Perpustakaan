<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Call Service
use DataTables;
use Carbon\Carbon;

// Call Model
use App\Models\User;
use App\Models\ClassModel;

class ClassController extends Controller
{
    public function index(){
        return view('class-management.index');
    }
    public function studentDatatable(){
        $data = User::where('deleted_at',null)->get();

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('books-management/category-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('books-management/'.$data['id'].'/category-edit')."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editCategory" onclick="editCategory('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onclick="confirm_me('.$delete_message.','.$delete_link.')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function addStudent(Request $request){
        $requestData = $request->all();
        $requestData['user_type_id'] = 1;
        $requestData['password'] = bcrypt($request->password);
        $insert = User::create($requestData);
        if($insert)
            return response()->json(['error' => false, 'message' => 'Berhasil menambahkan Siswa '.$request->name], 200);
        return response()->json(['error' => true, 'message' => 'Gagal menambahkan kelas'], 200);
    }
    
    // Class
    public function addClass(Request $request){
        $insert = ClassModel::create($request->all());
        if($insert)
            return response()->json(['error' => false, 'message' => 'Berhasil menambahkan kelas'], 200);
        return response()->json(['error' => true, 'message' => 'Gagal menambahkan kelas'], 200);

    }
    
    // Component by AJAX
    public function componentAddStudent(){
        $class = ClassModel::where('deleted_at',null)->get();
        return view('class-management.component-add-student', compact('class'));
    }
    public function componentStudentDatatable(){
        return view('class-management.component-student-datatable');
    }
}
