<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Pathfile;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    //Upload text file
    public function store(Request $request){
      $name = $request->file('chatfile')->getClientOriginalName();
      $ext = $request->file('chatfile')->getClientOriginalExtension();
      if($ext == 'txt'){        
        $path = $request->file('chatfile')->storeAs('chatfiles', time().'_'.\Auth::user()->name.$name);

        Pathfile::create(['filepath'=>$path , 'user_id' => \Auth::user()->id]);        
        return redirect('/display');
      }
      else {      
          return \Response::json(array('error' => 'Only text files')); 
      }      
    }   

}
