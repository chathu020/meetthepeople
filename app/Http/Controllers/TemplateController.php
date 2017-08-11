<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Response;

class TemplateController extends Controller
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
     * Display a listing of the resource.
     *
     * @return Response
     */
	public function index(Request $request)
    {
        $input = $request->all();
        if($request->get('search')){
            $items = Template::where("subject", "LIKE", "%{$request->get('search')}%")->orWhere("content", "LIKE", "%{$request->get('search')}%")
                ->get();//paginate(20);      
        }else{
          $items = Template::get();//paginate(20);
        }
        return Response::json(['data' => $items], 200); 
    }

	 /**
     * Validate Username is unique
     *
     * @return boolean
     */
	 public function checkSubject( $type)
	 {
		// Must not already exist in the `roomtype` column of `templates` table
	 	if($type){
	 		$rules = array('subject' => 'required|unique:templates');
	 		$validator = Validator::make(array('subject' =>$type), $rules);
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
                'subject' => 'required|max:255|unique:templates',
                'content' => 'required'                        
            ]);

            if($validator->fails()){
                return Response::json(['error' => $validator->errors()->getMessages()], 404);
            }

    		$input = $request->all();
            $template = Template::create($input);    		
    		return  response($template);
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
    	
    	return Template::find($id);
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
            'content' => 'required'                        
            ]);
            if($validator->fails()){
                return Response::json(['error' => $validator->errors()->getMessages()], 404);
            }
    		$template = Template::find($id);
            if($template){
                $input = $request->all();
                $template->update($input);    
                return response($template);
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
    	
    	$template = template::find($id);
    	if($template)
    		$template->delete();

    	return "template record successfully deleted #" . $request->input('id');
    }
}
