<?php

namespace App\Http\Controllers\farmer;

use App\Http\Controllers\Controller;
use App\User;
use App\Farmer_reg_2;
use App\Medical;
use App\Pending;
use App\FarmerExpense;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FarmerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(\auth()->user() == null){
        //     return view('farmer.index');

        // }else{
        //     return "farmer page after logged in, code farmer/FarmerController";
        // }
        return view('farmer.index');
    }


    public function changepassword()
    {
        return view('farmer.change-password');
    }

    public function updatepassword(Request $request)
    {
        request()->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'verify_password' => 'required'
        ]);

        $pass = auth()->user()->password;

        $current_password = request('current_password');
        $new_password = request('new_password');
        $confirm_password = request('verify_password');
        $hash=(\Illuminate\Support\Facades\Hash::check($current_password, $pass));
        $new=(\Illuminate\Support\Facades\Hash::check($new_password, $pass));
        $confirm=(\Illuminate\Support\Facades\Hash::check($confirm_password, $pass));


        if ($hash && $hash != $new && $hash!=$confirm && $new==$confirm ) {

           
               auth()->user()->update([
                'password' => Hash::make($new_password)
            ]);
            session()->flash('password_success', 'Password updated successfully');
            return back();
        }
            else if  (\Illuminate\Support\Facades\Hash::check($current_password, $pass) && \Illuminate\Support\Facades\Hash::check($new_password, $pass)&& \Illuminate\Support\Facades\Hash::check($confirm_password, $pass)) {
                session()->flash('password_failed', 'Password Same');
                return back();
            }


         else {
            session()->flash('password_failed', 'Password Change failed');
            return back();
        }
    }



}

