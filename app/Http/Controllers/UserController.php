<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Log;
use App\Http\Requests;
use App\User;
use App\Company;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vraca listu korisnika
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users=User::all();
        Log::info('Prikaz svih korisnika. Prikazuje se korisniku: '.Auth::user()['name']);
        return view('user.index',compact('users'));
    }

    /**
     * Vraca korisnika i njegove narudzbe
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user=User::find($id);
        Log::info('Prikaz korisnika s id:'.$id);
        $orders=$user->orders;

        for($i=0;$i<count($orders);$i++){
            $orders[$i]['taxi']=Company::find($orders[$i]->company_id);
        }

        return view('user.show',compact(['user','orders']));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('user.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request){

        $user= $request->all();
        $user['password']=bcrypt($user['password']);
        User::create($user);
        return redirect('user');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $user=User::findOrFail($id);
        return view('user.edit',compact('user'));
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request){
        $user=User::findOrFail($id);
        $user->update($request->all());
        return redirect('user');
    }

    /**
     * Brise korisnika (soft delete)
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id){
        User::destroy($id);
        return redirect('user');
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
