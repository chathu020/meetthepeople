<?php

namespace App\Http\Controllers;

use App\Models\CaseReference;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Response;

class CaseReferenceController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| CaseReference Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new caseReferences as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/
	
	/**
	 * Where to redirect caseReferences after login / registration.
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
            $items = CaseReference::where("description", "LIKE", "%{$request->get('search')}%")->get();//paginate(20);      
        }else{
          $items = CaseReference::get();//paginate(20);
        }

        return response($items); 
    }

	 /**
     * Validate Username is unique
     *
     * @return boolean
     */
	 public function checkcaseReference( $description)
	 {
		// Must not already exist in the `roomtype` column of `caseReferences` table
	 	if($description){
	 		$rules = array('description' => 'required|unique:casereferences');
	 		$validator = Validator::make(array('description' =>$description), $rules);
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
                'description' => 'required|max:255|unique:casereferences'
            ]);

            if($validator->fails()){
                return Response::json(['error' => $validator->errors()->getMessages()], 404);
            }

    		$input = $request->all();
            $input['countera']=$request->input('countera') === 'true'? true: false;
            $caseReference = CaseReference::create($input);    		
    		return  $caseReference;
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
    	$caseReference = CaseReference::find($id);
        $caseReference->countera = (boolean)$caseReference->countera;
    	return $caseReference;
    }

    /**
    */
    public function getcaseRefCounterA(){
        try{
            $casereferences = CaseReference::where('countera', '=', 1)->get();
            return response($casereferences);
        } catch (Exception $e) {
            return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
        }
        
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
                'description' => 'required|max:255'
            ]);
            if($validator->fails()){
                return Response::json(['error' => $validator->errors()->getMessages()], 404);
            }
    		$caseReference = CaseReference::find($id);
            if($caseReference){
                $input = $request->all();              
                $input['countera']=$request->input('countera') === 'true'? true: false;                
               $caseReference->update($input);    
                return response($caseReference);
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
    	
    	$caseReference = caseReference::find($id);
    	if($caseReference)
    		$caseReference->delete();

    	return "caseReference record successfully deleted #" . $request->input('id');
    }
}
