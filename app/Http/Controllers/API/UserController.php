<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\BooksOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function Login(Request $request)
    {
        $user = User::where('user_number', $request->user_number)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $data['token'] = $user->createToken('nApp')->accessToken;
                $data['id'] = $user->id;
                $data['user_number'] = $user->user_number;
                return response()->json(['error' => false, 'message' => 'Login success !', 'data' => $data], 200);
            }
            return response()->json(['error' => true, 'message' => 'Password is wrong'], 401);
        }
        return response()->json(['error' => true, 'message' => 'Username not found !'], 401);
    }
    public function orderBook(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'book_id' => ['required'],
        ]);

        $data = Books::where('id', $validated['book_id'])->where('ready', true)->orderBy('created_at', 'DESC')->first();
        
        if (!$data) {
            return response()->json(['error' => true, 'message' => 'Data not found!'], 200);
        }
        try {
            DB::transaction(function () use ($data) {
                $data->ready = false;
                $userType = Auth::guard('api')->user()->user_type_id;
                if ($userType == 1) {
                    $endDate = Carbon::now('Asia/Jakarta')->addDays(2)->toDateTimeString();
                } else {
                    $endDate = Carbon::now('Asia/Jakarta')->addDays(3)->toDateTimeString();
                }
                BooksOrder::create([
                    'user_id' => Auth::guard('api')->user()->id,
                    'book_id' => $data->id,
                    'status' => 'PENDING',
                    'start_date' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
                    'end_date' => $endDate
                ]);
                $data->save();
            });
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Simpan data error'], 200);
        }
        return response()->json([
            'error' => false, 'message' => 'Permohonam peminjaman sedang diproses oleh Admin, cek sekala berkala status peminjaman anda !'
        ], 200);
    }
}