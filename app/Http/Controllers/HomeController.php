<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxi= Company::pluck('name','id');
        return view('home',compact('taxi'));
    }
    public function getOrders()
    {
        $user = User::find(Auth::user()->id);
        $orders = $user->orders;
        for($i=0;$i<count($orders);$i++){
            $orders[$i]['taxiCompany']=Company::find($orders[$i]->company_id)->name;
        }

        return view('reservations',compact('orders'));
    }
}
