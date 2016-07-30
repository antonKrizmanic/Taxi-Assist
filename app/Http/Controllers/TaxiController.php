<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxiRequest;
Use \App\Company;
use App\Http\Requests;

class TaxiController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        $taxis=Company::oldest('name')->get();

        return view('taxi.index',compact('taxis'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        return view('taxi.create');
    }

    /**
     * @param CreateTaxiRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TaxiRequest $request){

        Company::create($request->all());
        return redirect('taxi');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $taxi=Company::findOrFail($id);
        return view('taxi.edit',compact('taxi'));
    }


    /**
     * @param $id
     * @param TaxiRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, TaxiRequest $request){
        $taxi=Company::findOrFail($id);
        $taxi->update($request->all());
        return redirect('taxi');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id){
        Company::destroy($id);
        return redirect('taxi');
    }
}
