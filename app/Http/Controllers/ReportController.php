<?php

namespace App\Http\Controllers;
use App\Models\CaseFile;
use App\Models\Accomodation;
use App\Models\CaseReference;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Response;
use PDF;
class ReportController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Template Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new templates as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/
	
	/**
	 * Where to redirect templates after login / registration.
	 *
	 * @var string
	 */
	

	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}	
    
    /**
     * get report B details
     *
     * @param  int $quarter
     * @param  int  $year
     * @return Response
     */
    public function reportB($quarter, $year) {
    	try {
            $cases = new Collection();
            $data = [];
            if($quarter == 1){
                $months = [1,2,3];
            }elseif ($quarter == 2) {
                $months = [4,5,6];
            }elseif ($quarter == 3) {
                $months = [7,8,9];
            }elseif ($quarter == 4) {
                $months = [10,11,12];
            }


            foreach ($months as $value) {
                $dates = array( );               
                $monthName = date("F", mktime(0, 0, 0, $value, 10));
                $cases =CaseFile::where( DB::raw('MONTH(created_at)'), '=',$value )->where( DB::raw('YEAR(created_at)'), '=',$year)->get();
                foreach ($cases as $case) {                       
                    array_push($dates,date_format($case->created_at,"Y/m/d") );
                }
                $result = array_unique($dates);
                array_push($data,['month'=>$monthName,'cases'=> $cases->count(), 'sessions'=>count($result)]); 
            }    
            return response($data); 
        } catch (Exception $e) {
          return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
      }
  }


function formASave(Request $request){
    session(['formA' => $request['data']]);
}

public function downloadFormA(Request $request){   
    $html= session('formA');
    $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape');
    return $pdf->download('formA.pdf');
}

function formBSave(Request $request){
     
    session(['formB' => $request['data']]);  
}

public function downloadFormB(Request $request){   
    $html= session('formB');    
    $pdf = PDF::loadHTML($html)->setPaper('a4', 'portrait');    
    return $pdf->download('formB.pdf');
}


function reportA($startdate, $enddate){ 
    $result = array(); 
    
    $refs = CaseReference::all();    
    array_push($result, $refs);//0- case refs
    $accomodations = Accomodation::where('accomodation', 'HDB')->orderBy('id', 'asc')->get();
    array_push($result,$accomodations );//1- HDB types
 
    $cases = DB::table('cases')
            ->select(DB::raw('count(cases.id) as total'), 'cases.caseRef_id','cases.caseRef_id','client.roomType')
           ->Join('clients as client', 'client.id', '=', 'cases.client_id') 
           ->where('client.accomodationType', 0) 
           ->where('cases.created_at', '>=', $startdate.' 00:00:00')
           ->where('cases.created_at', '<=', $enddate.' 24:60:60')
            ->groupBy('cases.caseRef_id')
            ->groupBy('client.roomType')
            ->orderBy('cases.caseRef_id', 'ASC')
            ->get();      
    array_push($result,$cases );// 2- HDB related data
    $accomodations = Accomodation::where('accomodation', 'Private')->orderBy('id', 'asc')->get();
    array_push($result,$accomodations );//3- Private types
    $cases = DB::table('cases')
            ->select(DB::raw('count(cases.id) as total'), 'cases.caseRef_id','cases.caseRef_id','client.roomType')
           ->Join('clients as client', 'client.id', '=', 'cases.client_id') 
           ->where('client.accomodationType', 1) 
           ->where('cases.created_at', '>=', $startdate.' 00:00:00')
           ->where('cases.created_at', '<=', $enddate.' 24:60:60')
            ->groupBy('cases.caseRef_id')
            ->groupBy('client.roomType')
            ->orderBy('cases.caseRef_id', 'ASC')
            ->get();        
            
        
    array_push($result,$cases );// 4 private related data
         //race -M

    $related = new Collection();    
    $cases =new Collection();  
    $cases =  DB::table('cases')
         ->select( DB::raw('count(cases.id) as total'),'cases.caseRef_id','client.race')
         ->Join('clients as client', 'client.id', '=', 'cases.client_id')       
         ->where('client.race', 0)
         ->where('cases.created_at', '>=', $startdate.' 00:00:00')
           ->where('cases.created_at', '<=', $enddate.' 24:60:60')
         ->groupBy('cases.caseRef_id')
         ->orderBy('cases.caseRef_id', 'ASC')
         ->get();
    $related = $cases->merge($related);
    $cases =new Collection();
    $cases =  DB::table('cases')
         ->select( DB::raw('count(cases.id) as total'),'cases.caseRef_id','client.race')
         ->Join('clients as client', 'client.id', '=', 'cases.client_id')        
         ->where('client.race', 1)
         ->where('cases.created_at', '>=', $startdate.' 00:00:00')
           ->where('cases.created_at', '<=', $enddate.' 24:60:60')
         ->groupBy('cases.caseRef_id')
         ->orderBy('cases.caseRef_id', 'ASC')
         ->get();
         $related = $cases->merge($related);
         $cases =new Collection();
         $cases =  DB::table('cases')
         ->select( DB::raw('count(cases.id) as total'),'cases.caseRef_id','client.race')
         ->Join('clients as client', 'client.id', '=', 'cases.client_id')         
         ->where('client.race', 2)
         ->where('cases.created_at', '>=', $startdate.' 00:00:00')
           ->where('cases.created_at', '<=', $enddate.' 24:60:60')
         ->groupBy('cases.caseRef_id')
         ->orderBy('cases.caseRef_id', 'ASC')
         ->get();
         $related = $cases->merge($related);
         $cases =new Collection(); 
         $cases =  DB::table('cases')
         ->select( DB::raw('count(cases.id) as total'),'cases.caseRef_id', 'client.race')
         ->Join('clients as client', 'client.id', '=', 'cases.client_id')     
         ->where('client.race', 3)
         ->where('cases.created_at', '>=', $startdate.' 00:00:00')
           ->where('cases.created_at', '<=', $enddate.' 24:60:60')
         ->groupBy('cases.caseRef_id')
         ->orderBy('cases.caseRef_id', 'ASC')
         ->get();
         $related = $cases->merge($related);
         array_push($result,$related );//5-race

        //age
         $related = new Collection(); 
         $year = $this->reverse_birthday(30);
         $cases = new Collection(); 
         $cases =  DB::table('cases')
         ->select( DB::raw('count(cases.id) as total'),'cases.caseRef_id', DB::raw("'30' as age"))
         ->Join('clients as client', 'client.id', '=', 'cases.client_id')         
         ->whereYear('client.dateOfBirth', '>=',$year)
         ->where('cases.created_at', '>=', $startdate.' 00:00:00')
           ->where('cases.created_at', '<=', $enddate.' 24:60:60')
         ->groupBy('cases.caseRef_id')
         ->orderBy('cases.caseRef_id', 'ASC')
         ->get();
         $related = $cases->merge($related);       

         $year1 = $this->reverse_birthday(31);
         $year2 = $this->reverse_birthday(45);
         $cases = new Collection(); 
         $cases =  DB::table('cases')
         ->select( DB::raw('count(cases.id) as total'),'cases.caseRef_id',DB::raw("'31'  as age") )
         ->Join('clients as client', 'client.id', '=', 'cases.client_id') 
         ->whereYear('client.dateOfBirth', '>=',$year2)        
         ->whereYear('client.dateOfBirth', '<=',$year1)
         ->where('cases.created_at', '>=', $startdate.' 00:00:00')
           ->where('cases.created_at', '<=', $enddate.' 24:60:60')
         ->groupBy('cases.caseRef_id')
         ->orderBy('cases.caseRef_id', 'ASC')
         ->get();

         $related = $cases->merge($related);

         $year1 = $this->reverse_birthday(46);
         $year2 = $this->reverse_birthday(60);
         $cases =  DB::table('cases')
         ->select( DB::raw('count(cases.id) as total'),'cases.caseRef_id',DB::raw("'46' as age"))
         ->Join('clients as client', 'client.id', '=', 'cases.client_id') 
         ->whereYear('client.dateOfBirth', '>=',$year2)        
         ->whereYear('client.dateOfBirth', '<=',$year1)
         ->where('cases.created_at', '>=', $startdate.' 00:00:00')
           ->where('cases.created_at', '<=', $enddate.' 24:60:60')
         ->groupBy('cases.caseRef_id')
         ->orderBy('cases.caseRef_id', 'ASC')
         ->get();
         $related = $cases->merge($related);

         $year = $this->reverse_birthday(61);
         $cases =  DB::table('cases')
         ->select( DB::raw('count(cases.id) as total'),'cases.caseRef_id',DB::raw("'61'  as age"))
         ->Join('clients as client', 'client.id', '=', 'cases.client_id')         
         ->whereYear('client.dateOfBirth', '<=',$year)
         ->where('cases.created_at', '>=', $startdate.' 00:00:00')
           ->where('cases.created_at', '<=', $enddate.' 24:60:60')
         ->groupBy('cases.caseRef_id')
         ->orderBy('cases.caseRef_id', 'ASC')
         ->get();
        
         $related = $cases->merge($related);
         array_push($result,$related );//5 birthdate
         return response($result);
     }

     function reverse_birthday( $years ){
      $time = new \DateTime('now');
      $newtime = $time->modify('-'.strval($years ).' years')->format('Y');
      return  $newtime;
  }
}
