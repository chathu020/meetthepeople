<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Postalcode;
use App\Models\Accomodation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Response;
use Session;

use App\Http\Controllers\Controller;
class ClientController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Client Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new clients as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    /**
     * Where to redirect clients after login / registration.
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
        $input = $request->all();
        if($request->get('search')){
            $items = Client::where("name", "LIKE", "%{$request->get('search')}%")->orWhere("nric", "LIKE", "%{$request->get('search')}%")
            ->get();//paginate(20);      
        }else{
          $items = Client::get();//paginate(20);
      }
      return response($items);
  }

  public function create()
  {
   return view('client.create');
}

public function edit($id)
{
    $client = Client::findOrFail($id);
    $client->sex = $client->sex == 1 ? 'female' : 'male';
    $client->color = $client->color == 1 ? 'blue' : 'pink';
    $client->race = $client->race == 0 ? 'C' : ($client->race == 1 ? 'M':($client->race ==2 ? 'I': 'Other') );
    $client->accomodationType = $client->accomodationType == 1 ? 'Private' : 'Hdb';
    $client->status = $client->status == 1 ? 'rented' : 'own';
    $client->language = explode(',',$client->language);
    $client->preferred = explode(',',$client->preferred); 
    $client->resident = explode(',',$client->resident);      
    if($client->homeTel == 0)
        $client->homeTel = null;
    if($client->pagerNo == 0)
        $client->pagerNo = null;
    if($client->officeTel == 0)
        $client->officeTel = null;
    if($client->handphone == 0)
        $client->handphone = null;
    return view('client.edit')->with('client', $client);
}

     /**
     * Validate Clientname is unique
     *
     * @return boolean
     */
     public function checkNRIC( Request $request)
     {        
        $nric =$_GET['nric'];        
        // Must not already exist in the `nric` column of `clients` table
        if($nric ){
            $rules = array('nric' => 'required|unique:clients');
            $validator = Validator::make(array('nric' =>$nric), $rules);
            if ($validator->fails()) {                               
                return Response::json(['valid' => false]);
            }
            else {
               return Response::json([ "valid"=> true]);
           }
       }else 

       return Response::json([ "valid"=>true]);
   }

       /**
     * Get client by nric is unique
     *
     * @return boolean
     */
       public function getClientbyNRIC( $nric)
       { 
        if($nric ){
           $client = Client::where('nric', $nric)->first();
           if($client){
            if($client->homeTel == 0)
                $client->homeTel = '';
            if($client->pagerNo == 0)
                $client->pagerNo = '';
            if($client->officeTel == 0)
                $client->officeTel = '';
            if($client->handphone == 0)
                $client->handphone = '';
            return response($client);
           } 
         }
        return null;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        try{
            $this->validate($request, [
               'nric' => 'required|max:255|unique:clients',
               'name' => 'required|max:255'                
               ]);

            $request['sex'] =  $request->input("sex") == 'female' ? 1 : 0;
            $request['color'] = $request->input("color") == 'blue' ? 1 : 0;
            $request['race'] = $request->input("race") == 'C' ? 0: ($request->input("race") == 'M' ? 1: ($request->input("race") == 'I'?2: 3 )) ;
            $request['accomodationType'] = $request->input("accomodationType") == 'Private' ? 1 : 0;
            $request['status'] = $request->input("status") == 'rented' ? 1 : 0;
            $request['noContact'] = $request->input("noContact") == '1' ? 1 : 0;
            $request['language']= implode(',', (array) $request->input('language'));
            $request['preferred']= implode(',', (array) $request->input('preferred'));     
            if($request['roomType'] == "")   
                $request['roomType']= null; 
            $input = $request->all();
           
            $client = Client::create($input);
            Session::flash('flash_message', 'Client is registered successfully!');
            return view('client.create');

        } catch (Exception $e) {
          return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
      }       
  }

  public function updateRegister(Request $request, $id=null) {
    try {      
           $request['sex'] =  $request->input("sex") == 'female' ? 1 : 0;
           $request['color'] = $request->input("color") == 'blue' ? 1 : 0;
           $request['race'] = $request->input("race") == 'C' ? 0: ($request->input("race") == 'M' ? 1: ($request->input("race") == 'I'?2: 3 )) ;
           $request['accomodationType'] = $request->input("accomodationType") == 'Private' ? 1 : 0;
           $request['status'] = $request->input("status") == 'rented' ? 1 : 0;
           $request['noContact'] = $request->input("noContact") == 'true' ? 1 : 0;  
           $request['language']= implode(',', (array) $request->input('language'));
           $request['preferred']= implode(',', (array) $request->input('preferred')); 
           $request['resident']= implode(',', (array) $request->input('resident')); 
           if($request['roomType'] == "")   
                $request['roomType']= null;    
            $input = $request->all();
        if($id != null){
            $client = Client::findOrFail($id);
            if($client){
                $validator = Validator::make($request->all(), [         
                   'name' => 'required|max:255'                
                   ]);
                if($validator->fails()){
                    return Response::json(['error' => $validator->errors()->getMessages()], 404);
                }              

                $client->fill($input)->save();
                return response("success");  
            }else return Response::json(['error' => 'Client not found!'], 404);
        }
        else {
               //add new
            $validator = Validator::make($request->all(), [
               'nric' => 'required|max:255|unique:clients',
               'name' => 'required|max:255'                
               ]);
            if($validator->fails()){
                return Response::json(['error' => $validator->errors()->getMessages()], 404);
            }
            $client = Client::create($input);                
            return response("success");
        }                       
    return response("error");
} catch (Exception $e) {
  return "Error";
}
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */  
    public function show($id)
    {
        $client = Client::findOrFail($id);

        return view('client.show')->withClient($client);
    }

 /**
     * Get the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
 public function getClient($id) {
    $client =Client::with('accommodation')->where('nric', '=' ,$id)->firstOrFail();
    return response($client);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {

        try {
            $client = Client::findOrFail($id);

            $this->validate($request, [
                'nric' => 'required',
                'name' => 'required'
                ]);
            $request['sex'] =  $request->input("sex") == 'female' ? 1 : 0;
            $request['color'] = $request->input("color") == 'blue' ? 1 : 0;
            $request['race'] = $request->input("race") == 'C' ? 0: ($request->input("race") == 'M' ? 1: ($request->input("race") == 'I'?2: 3 )) ;
            $request['accomodationType'] = $request->input("accomodationType") == 'Private' ? 1 : 0;
            $request['status'] = $request->input("status") == 'rented' ? 1 : 0;
            $request['noContact'] = $request->input("noContact") == '1' ? 1 : 0;  
            $request['language']= implode(',', (array) $request->input('language'));
            $request['preferred']= implode(',', (array) $request->input('preferred')); 
            $request['resident']= implode(',', (array) $request->input('resident')); 
            if($request['roomType'] == "")   
                $request['roomType']= null;    
            $input = $request->all();
            $client->fill($input)->save();                
            \Session::flash('flash_message','Successfully Updated the Client!'); //<--FLASH MESSAGE
            $client = Client::findOrFail($id);
            $client->sex = $client->sex == 1 ? 'female' : 'male';
            $client->color = $client->color == 1 ? 'blue' : 'pink';
            $client->race = $client->race == 0 ? 'C' : ($client->race == 1 ? 'M':($client->race ==2 ? 'I': 'Other') );
            $client->accomodationType = $client->accomodationType == 1 ? 'Private' : 'Hdb';
            $client->status = $client->status == 1 ? 'rented' : 'own';
            $client->language = explode(',',$client->language);
            $client->preferred = explode(',',$client->preferred); 
            $client->resident = explode(',',$client->resident);      
            if($client->homeTel == 0)
                $client->homeTel = null;
            if($client->pagerNo == 0)
                $client->pagerNo = null;
            if($client->officeTel == 0)
                $client->officeTel = null;
            if($client->handphone == 0)
                $client->handphone = null;
            return view('client.edit')->with('client', $client);                

        } catch (Exception $e) {
          return "Error";
      }
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id) {

        $client = client::find($id);
        if($client)
            $client->delete();

        return "client record successfully deleted #" . $request->input('id');
  }


  public function getPostalCodes(){
    $codes = Postalcode::get();
    return response($codes);
  }

}
