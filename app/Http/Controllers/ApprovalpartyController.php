<?php

namespace App\Http\Controllers;

use App\Models\Approvalparty;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Response;

class ApprovalpartyController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Approvalparty Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new approvalpartys as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/
	
	/**
	 * Where to redirect approvalpartys after login / registration.
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
    	return Validator::make($data, [

    		]);
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
	 		$items = Approvalparty::where("authorizedName", "LIKE", "%{$request->get('search')}%")->orWhere("designation", "LIKE", "%{$request->get('search')}%")
	 		->get();//paginate(20);      
	 	}else{
	 		$items = Approvalparty::get();//paginate(20);
	 	}
	 	return response($items);
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
    			'authorizedName' => 'required|max:255',
    			'designation' => 'required|max:255'                  
    			]);

    		if($validator->fails()){
    			return Response::json(['error' => $validator->errors()->getMessages()], 404);
    		}
    		$approvalparties = DB::table('approvalparties')->where([
    			['authorizedName', '=', $request->input('authorizedName')],
    			['designation', '=', $request->input('designation')],
    			])->get();
    		if (count($approvalparties)) { 
    			return Response::json(['error' => 'Entry already Exists!'], 404);
    		}
    		$input = $request->all();
    		$approvalparty = Approvalparty::create($input);

    		return  response($approvalparty);

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
    	
    	return Approvalparty::find($id);
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
    			'authorizedName' => 'required|max:255',
    			'designation' => 'required|max:255'                     
    			]);
    		if($validator->fails()){
    			return Response::json(['error' => $validator->errors()->getMessages()], 404);
    		}
    		$approvalparties = DB::table('approvalparties')->where([
    			['authorizedName', '=', $request->input('authorizedName')],
    			['designation', '=', $request->input('designation')],
    			])->get();
    		if (count($approvalparties)) { 
    			return Response::json(['error' => 'Entry already Exists!'], 404);
    		}
    		$approvalparty = Approvalparty::find($id);
    		if($approvalparty){
    			$input = $request->all();
    			$approvalparty->update($input);    
    			return response($approvalparty);
    		}

    		return Response::json(['error' => 'Entry do not Exists!'], 404);
    	} catch (Exception $e) {
    		return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
    	}

    }

    public function setdefault($id){
        try{
            $party = Approvalparty::where('default', '=', true)->get()->first();
            if($party){
                $party->default = false;
                $party->save();
            }
            $approvalparty = Approvalparty::find($id);
            if($approvalparty){
               $approvalparty->default = true;
                $approvalparty->save();   
                return response($approvalparty);
            }

            return Response::json(['error' => 'Entry do not Exists!'], 404);
        } catch (Exception $e) {
            return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
        }
    }

    public function getDefault(){
        try{
            $party = Approvalparty::where('default', '=', true)->get()->first();
            if($party){
               return response($party);
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
    	
    	$approvalparty = approvalparty::find($id);
    	if($approvalparty)
    		$approvalparty->delete();

    	return "approvalparty record successfully deleted #" . $request->input('id');
    }
}
