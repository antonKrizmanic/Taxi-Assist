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
    
}
