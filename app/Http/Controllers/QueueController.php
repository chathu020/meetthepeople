<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Response;
class QueueController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Queue Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new queues as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    /**
     * Where to redirect queues after login / registration.
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
     * Display a listing of the resource.
     *
     * @return Response
     */
     public function index(Request $request)
     {
        try{
           $items=null;
        $input = $request->all();          
        if($request->get('search')){
            $items = Queue::where("name", "LIKE", "%{$request->get('search')}%")->orWhere("status", "LIKE", "%{$request->get('search')}%")
            ->get();//paginate(20);      
        }else{
            if($request->get('queueId')== '0'){
                $items = DB::table('queue')
                ->join('clients', 'queue.nric', '=', 'clients.nric')   
                ->leftJoin('postalcodes', 'clients.postalCode', '=', 'postalcodes.code')          
                ->select(DB::raw('queue.id,queue.queueno, queue.nric,queue.created_at, postalcodes.zone,(CASE WHEN queue.status="AV" THEN "Available" WHEN queue.status="P" THEN "Pending" WHEN queue.status="IP" THEN "In Progress" ELSE "Available" END) as status, clients.name, clients.language, clients.color'))
                ->whereIn('queue.status', array('AV','P','IP'))
                ->orderBy('queue.created_at', 'asc')
                ->get();
            }elseif($request->get('queueId')== '1'){
                $items = DB::table('queue')
                ->join('clients', 'queue.nric', '=', 'clients.nric') 
                ->join('cases', 'queue.id', '=', 'cases.queueno') 
                ->leftJoin('postalcodes', 'clients.postalCode', '=', 'postalcodes.code')           
                ->select(DB::raw('max(queue.id) as id, max(queue.nric) as nric, max(queue.queueno) as queueno, max(DATE(queue.created_at)) as created_at, max(postalcodes.zone) as zone,max((CASE WHEN queue.status="AVM" THEN "Available" WHEN queue.status="PM" THEN "Pending"  WHEN queue.status="IPM" THEN "In Progress" ELSE "Available" END) ) as status, max(clients.name) as name, max(clients.language) as language, max(clients.color) as color, count(cases.queueno) as casecount'))
                ->whereIn( 'queue.status', array('AVM','PM','IPM'))
                ->orderBy('queue.created_at', 'asc')
                ->groupBy('cases.queueno')
                ->get();
            }elseif($request->get('queueId')== '2'){
                $items = DB::table('queue')
                ->join('clients', 'queue.nric', '=', 'clients.nric') 
                ->leftJoin('postalcodes', 'clients.postalCode', '=', 'postalcodes.code')           
                ->select(DB::raw('queue.id, queue.nric,queue.queueno, queue.caseref,queue.created_at, postalcodes.zone,(CASE WHEN queue.status="CA" THEN "Available" WHEN queue.status="IPC" THEN "In Progress"  WHEN queue.status="IP" THEN "In Progress" ELSE "Available" END) as status, clients.name, clients.language, clients.color'))
                ->whereIn( 'queue.status', array('CA', 'IPC'))
                ->orderBy('queue.created_at', 'asc')
                ->get();
            }

        }          
        return response($items);  
        } catch (Exception $e) {
          return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
      }    
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function addQueue(Request $request) {     
        try{        
            $reRegister=$request->input('reRegister');
            $casereference = $request->input('casereference'); 

            $nric = $request->input('nric');     
            if( $reRegister == "false"){         
                $queues = DB::table('queue')->whereIn('status', array('AV','P','IP', 'CA'))->where('nric', '=', $nric)->whereDate('created_at', '=', date('Y-m-d'))->get();           
                if (count($queues)) { 
                    return Response::json(['exists' => '1']);
                }
            }

            $highest =  DB::table('queue')->whereDate('created_at', '=', date('Y-m-d'))->max('queueNo');    
            if($highest)
                $queueNo = $highest+1;
            else $queueNo =1;
            $queue = new queue;
            $queue->queueNo = $queueNo;
            $queue->nric = $nric;
            $queue->caseref = $casereference;
            if($casereference == '0' || $casereference == null){            
                $queue->status = 'AV';
            }else{
                $queue->status = 'CA';
            }

            $queue->save();         
            return  response($queue);                

        } catch (Exception $e) {
          return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
      }       
  }



    /**
     * Get the specified resource and update
     *
     * @param  int  $id
     * @return Response
     */
    public function updateQueue($status,$id) {
        try{ 
            $queue =  Queue::find($id);

            if($status == "P"){              
              if($queue->status == 'AV')
                $queue->status = 'P'; 
            elseif($queue->status =='AVM')
                $queue->status = 'PM'; 
            elseif($queue->status =='IP')
                $queue->status = 'P';
            elseif($queue->status =='IPM')
                $queue->status = 'PM';    
            }elseif($status == "IP"){
               if($queue->status == 'AV' || $queue->status == 'P'){           
                   $queue->status = 'IP';
               }
               elseif($queue->status== 'AVM' ||$queue->status== 'PM'){             
                $queue->status = 'IPM'; 
            }
            elseif($queue->status== 'CA')
                $queue->status = 'IPC';        
            }elseif($status == "AV"){
                   if($queue->status == 'IP'){           
                       $queue->status = 'AV';
                   }
                   elseif($queue->status== 'IPM'){             
                    $queue->status = 'AVM'; 
                }
                elseif($queue->status== 'IPC')
                    $queue->status = 'CA'; 
            }elseif($status == "C"){
               if($queue->status == 'IP')
                $queue->status = 'AVM'; 
            elseif($queue->status =='IPM')
                $queue->status = 'C'; 
            elseif($queue->status == 'IPC')
                $queue->status = 'C'; 
            }
$queue->writer_id = \Auth::id();
$queue->save();
$fullqueue= DB::table('queue')
->join('clients', 'queue.nric', '=', 'clients.nric')            
->select(DB::raw('queue.id, queue.nric,queue.caseref,queue.queueno,queue.created_at,(CASE WHEN queue.status="AVM" THEN "Available" WHEN queue.status="AV" THEN "Available" WHEN queue.status="PM" THEN "Pending" WHEN queue.status="P" THEN "Pending"  WHEN queue.status="IP" THEN "In Progress" ELSE "Available" END) as status, clients.name, clients.language, clients.color'))
->where('queue.id', $id)
->get();

return  response($fullqueue);
} catch (Exception $e) {
    return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
}  
}   

function getqueuedata(){
    //current queue no
    //today pending
 $writer = \Auth::id();
 $current =DB::table('queue')
 ->join('users', 'users.id', '=', 'queue.writer_id')            
 ->selectRaw('users.name, queue.queueNo,queue.created_at')
 ->where( 'queue.current', 1)
 ->where(function($q){
  $q->whereDate('queue.created_at', '=', date('Y-m-d'));
  $q->orWhereDate('queue.created_at', '=', date('Y-m-d', strtotime( '-1 days' )));
})->get();

 $pending =Queue::whereIn( 'queue.status', array('P','PC', 'PM'))->where(function($q){
  $q->whereDate('queue.created_at', '=', date('Y-m-d'));
  $q->orWhereDate('queue.created_at', '=', date('Y-m-d', strtotime( '-1 days' )));
  })->pluck('queueNo');
 $currentMP =DB::table('queue')
 ->join('users', 'users.id', '=', 'queue.writer_id')            
 ->selectRaw('users.name , queue.queueNo, queue.created_at')
 ->where( 'queue.current', 2)
 ->where(function($q){
  $q->whereDate('queue.created_at', '=', date('Y-m-d'));
  $q->orWhereDate('queue.created_at', '=', date('Y-m-d', strtotime( '-1 days' )));
})->get();   
 return Response::json(['current' =>$current, 'pending'=> $pending, 'currentMP'=> $currentMP]);

}

function callQueue($queueid, $id){ 
  $writer = \Auth::id();
  $queuecurrent = null;
    //current queue no  
    if($queueid == "0" ){
      $current = 1;
      $status = 'AV';    
    }else if($queueid == "2"){
      $current = 1;
      $status = 'CA';   
    }else if($queueid == "1"){
      $current = 2;
      $status = 'AVM';
    }
if($id != "null" ){   
    $queuecurrent =  Queue::find($id); 
     $queueno = $queuecurrent->queueNo;
   $queue1 =  Queue::where('current', 1)->where('queueno', $queueno)->first(); 
  if($queue1)
     return Response::json(['data' => '1'], 200);       
}else{  
    $next =  DB::table('queue')->where( 'queue.status',$status)->whereDate('created_at', '=', date('Y-m-d', strtotime( '-1 days' )))->min('queueNo');
    if($next){
        $queuecurrent =Queue::where('queueNo', $next)->where( 'queue.status',$status)->whereDate('created_at', '=', date('Y-m-d', strtotime( '-1 days' )))->first();
    } else{
        $next =  DB::table('queue')->where( 'queue.status',$status)->whereDate('created_at', '=', date('Y-m-d'))->min('queueNo');
        if($next){
            $queuecurrent =Queue::where('queueNo', $next)->where( 'queue.status',$status)->whereDate('created_at', '=', date('Y-m-d'))->first();
        } 
    }
}
if($queuecurrent){
   $queue1 =  Queue::where('current', 1)->where('queueno', $queuecurrent->queueNo)->first(); 
  if($queue1)
     return Response::json(['data' => '1'], 200);  
}

  if($queueid == "0" || $queueid == "2"){
    $queues =  Queue::where('current', 1)->orderBy('updated_at', 'DESC')->get(); 
    $i=1;
    foreach ($queues as $q){ 
      if($i > 1){
        $q->current = 0;
        $q->save();
      }
      $i++;
}            
}else if($queueid == "1"){ 
    $queue =  Queue::where('current', 2)->get()->first(); 
    if($queue){
    $queue->current = 0;
    $queue->save();
}       
}


if($queuecurrent != null){
    $queuecurrent->current = $current;
    $queuecurrent->writer_id = $writer;
    $queuecurrent->save();
}
return response($queuecurrent);

}

function getNextQueueId($queueid){
  if($queueid == "0" ){
      $current = 1;
      $status = 'AV';    
    }else if($queueid == "2"){
      $current = 1;
      $status = 'CA';   
    } else if($queueid == "1"){  
    $status = 'AVM';   
}
  try{
    $next =  DB::table('queue')->where( 'queue.status',$status)->whereDate('created_at', '=', date('Y-m-d', strtotime( '-1 days' )))->min('queueNo');
    if(!$next){       
        $next =  DB::table('queue')->where( 'queue.status',$status)->whereDate('created_at', '=', date('Y-m-d'))->min('queueNo');
  }
  return $next;
  } catch (Exception $e) {
    return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
}  

}

}
