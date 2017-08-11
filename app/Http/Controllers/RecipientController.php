<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Response;

class RecipientController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Recipient Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new recipients as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/
	
	/**
	 * Where to redirect recipients after login / registration.
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
            $items = Recipient::where("organization", "LIKE", "%{$request->get('search')}%")->orWhere("address", "LIKE", "%{$request->get('search')}%")
                ->orWhere("attention", "LIKE", "%{$request->get('search')}%")->get();//paginate(20);      
        }else{
          $items = Recipient::get();//paginate(20);
        }

        return Response::json(['data' => $items], 200); 
    }

	 /**
     * Validate Username is unique
     *
     * @return boolean
     */
	 public function checkOrganization( $type)
	 {
		// Must not already exist in the `roomtype` column of `recipients` table
	 	if($type){
	 		$rules = array('organization' => 'required|unique:recipients');
	 		$validator = Validator::make(array('organization' =>$type), $rules);
	 		if ($validator->fails()) {	
	 			return "false";
	 		}
	 		else {
	 			return "true";
	 		}
	 	}

	 	return "false";
	 }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
    	try{
            $validator = Validator::make($request->all(), [
                'organization' => 'required|max:255|unique:recipients',
                'address' => 'required'                             
            ]);

            if($validator->fails()){
                return Response::json(['error' => $validator->errors()->getMessages()], 404);
            }

    		$input = $request->all();
            $recipient = Recipient::create($input);    		
    		return  $recipient;
    	} catch (Exception $e) {
    		return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
    	}    	
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
    	
    	return Recipient::find($id);
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
            $validator = Validator::make($request->all(), [
                'organization' => 'required|max:255',
                'address' => 'required'
            ]);
            if($validator->fails()){
                return Response::json(['error' => $validator->errors()->getMessages()], 404);
            }
    		$recipient = Recipient::find($id);
            if($recipient){
                $input = $request->all();
                $recipient->update($input);    
                return response($recipient);
            }   	
    		return Response::json(['error' => 'Entry do not Exists!'], 404);
    	} catch (Exception $e) {
    		return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
    	}

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id) {
    	
    	$recipient = recipient::find($id);
    	if($recipient)
    		$recipient->delete();

    	return "recipient record successfully deleted #" . $request->input('id');
    }
}
