<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Pathfile;

class DisplayController extends Controller
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
        return view('display');
    }

    //Get content from file

    public function getContent(Request $request) 
    {
       $input = $request->all();
        
        $fromArray = explode('-', $input['fromDate']); 
         
        $fromyear = str_split($fromArray[0] , 2);
         
        $newfrom = $fromArray[1].'/'.$fromArray[2].'/'.$fromyear[1];
         
        $toArray = explode('-', $input['toDate']); 
         
        $toyear = str_split($toArray[0] , 2);
         
        $newto = $toArray[1].'/'.$toArray[2].'/'.$toyear[1];

        $from = $newfrom;    //  whatsapp  mon/date/year  6/14/16
        $to = $newto;

        if($input['personName']){
          $per = $input['personName'];
          $both = false;
        } elseif ($input['both']) {
          $both = true;
          $per = false;
        }else{
            return \Response::json(array('error' => 'Select atleast one person or both'));
        }
        
        $query = 'select filepath from pathfiles where user_id = '.\Auth::user()->id. ' order by created_at desc LIMIT 1';
         $filename = \DB::select($query); 

        try
        {
           
          $fileName = storage_path('app/').$filename[0]->filepath;

          $file = fopen($fileName , 'r');
          
          $array = array();

            $i = 0;


            while($line = fgets($file))
            {
                $array[$i] = explode(',', $line);   
                $i++;   
            }

            $selected_array = array();
            $textToDisplay = array();

            $j = 0;

            foreach ($array as $key => $value) { 
                    if(strtotime($array[$key][0]) >= strtotime($from) &&  strtotime($array[$key][0]) <= strtotime($to)) {
                        if($per){
                           if(stripos($array[$key][1] , $per)) {
                             $textToDisplay[$j] = $array[$key];
                              $no_date = explode(':' ,$array[$key][1]);
                              $selected_array[$j] = preg_replace('/[^a-z]/i', ' ', end($no_date));
                              $j++;
                           }    
                        } elseif ($both) {
                            $textToDisplay[$j] = $array[$key];
                            $no_date = explode(':' ,$array[$key][1]);
                            $selected_array[$j] = preg_replace('/[^a-z]/i', ' ', end($no_date));
                            $j++;               
                        }else {
                          echo "Select atleast one person";
                        } 
                    }       
                }

            $final_txt = '';
            foreach ($selected_array as $key => $value) {
                    $final_txt  .=  $selected_array[$key] . " ";
            }
            
            fclose($file);
            if(count($textToDisplay) == 0){
              return \Response::json(array('error' => 'No data found for selected Dates try again'));
            }
            return view('/texts' , compact('textToDisplay'));
        }
        catch (Illuminate\Filesystem\FileNotFoundException $exception)
        {
          return die("The file doesn't exist");
        }
    }
}
