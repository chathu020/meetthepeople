<?php

namespace App\Http\Controllers;

use App\Models\Accomodation;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Hash;
use Response;
class AccomodationController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Accomodation Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new accomodations as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/
	
	/**
	 * Where to redirect accomodations after login / registration.
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
            $items = Accomodation::where("accomodation", "LIKE", "%{$request->get('search')}%")->orWhere("roomType", "LIKE", "%{$request->get('search')}%")
                ->get();//paginate(20);      
        }else{
          $items = Accomodation::get();//paginate(20);
        }
        return Response::json(['data' => $items], 200); 
    }

	 /**
     * Validate Username is unique
     *
     * @return boolean
     */
	 public function checkRoomType( $type)
	 {
		// Must not already exist in the `roomtype` column of `accomodations` table
	 	if($type){
	 		$rules = array('roomType' => 'required|unique:accomodations');
	 		$validator = Validator::make(array('roomType' =>$type), $rules);
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
            'accomodation' => 'required|max:255',
            'roomType' => 'required|max:255|unique:accomodations'                        
            ]);
            if($validator->fails()){
            return Response::json(['error' => $validator->errors()->getMessages()], 404);
            }
    		$input = $request->all();
            $accomodation = Accomodation::create($input);
            return  response($accomodation);

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
    	
    	return Accomodation::find($id);
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
            'accomodation' => 'required|max:255',
            'roomType' => 'required|max:255|unique:accomodations'                        
            ]);
            if($validator->fails()){
            return Response::json(['error' => $validator->errors()->getMessages()], 404);
            }
    		$accomodation = Accomodation::find($id);
            if($accomodation){
                $input = $request->all();
                $accomodation->update($input);    
                return response($accomodation);
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
    	
    	$accomodation = accomodation::find($id);
    	if($accomodation)
    		$accomodation->delete();

    	return "accomodation record successfully deleted #" . $request->input('id');
    }

    /**
     * Get the accomodation types 
     *
     * @param  string  accommodation
     * @return Response
     */
    public function getAccomodationTypes($type){
        if($type == 'all')
            $accomodations = Accomodation::orderBy('roomType')->get();
         else
            $accomodations = DB::table('accomodations')->where('accomodation', $type)->orderBy('roomType')->get();
    
    return response($accomodations);
    }
    
}
