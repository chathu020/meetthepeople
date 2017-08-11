<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\CaseFile;
use App\Models\Queue;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $clientsCount = Client::whereDate('created_at', '=', date('Y-m-d'))
                ->orderBy('created_at', 'desc')
                ->get()->count();
        $casesCount = CaseFile::whereDate('created_at', '=', date('Y-m-d'))
                ->orderBy('created_at', 'desc')
                ->get()->count();
        $cases = CaseFile::take(10)->get();
        
        $writerQueue = DB::table('queue')
                ->join('clients', 'queue.nric', '=', 'clients.nric')            
                ->select(DB::raw('queue.id,queue.nric,(CASE WHEN queue.status="AV" THEN "Available" WHEN queue.status="P" THEN "Pending" WHEN queue.status="IP" THEN "In Progress" ELSE "Available" END) as status, clients.name'))
                ->whereIn('queue.status', array('AV','P','IP'))->whereDate('queue.created_at', '=', date('Y-m-d'))
                ->orderBy('queue.created_at', 'desc')
                ->take(10)->get();
        
        $mpQueue = DB::table('queue')
                ->join('clients', 'queue.nric', '=', 'clients.nric')            
                ->select(DB::raw('queue.id, queue.nric,(CASE WHEN queue.status="AVM" THEN "Available" WHEN queue.status="PM" THEN "Pending"  WHEN queue.status="IP" THEN "In Progress" ELSE "Available" END) as status, clients.name'))
                ->whereIn( 'queue.status', array('AVM','PM','IPM'))->whereDate('queue.created_at', '=', date('Y-m-d'))
                ->orderBy('queue.created_at', 'desc')
                ->take(10)->get();       
       
        return view('home')->with('clientsCount', $clientsCount)->with('casesCount', $casesCount)
                ->with('writerQueue', $writerQueue)
                ->with('mpQueue', $mpQueue)
                ->with('cases', $cases);
    }
}
