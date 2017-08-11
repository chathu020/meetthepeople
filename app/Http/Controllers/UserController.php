<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Response;
class UserController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| User Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/
	
	/**
	 * Where to redirect users after login / registration.
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
            $items = User::with('roles')->where("name", "LIKE", "%{$request->get('search')}%")->orWhere("email", "LIKE", "%{$request->get('search')}%")
            ->get();//paginate(20);      
        }else{
          $items = User::with('roles')->get();//paginate(20);
      }
      return response($items);
  }

	 /**
     * Validate Username is unique
     *
     * @return boolean
     */
	 public function checkUsername( $username)
	 {
		// Must not already exist in the `username` column of `users` table
	 	if($username){
	 		$rules = array('username' => 'required|unique:users');
	 		$validator = Validator::make(array('username' =>$username), $rules);
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
            'username' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6'        
            ]);

         if($validator->fails()){
            return Response::json(['error' => $validator->errors()->getMessages()], 404);
        }

        $user = new user;
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->phonenumber = $request->input('phonenumber');
        $user->email = $request->input('email');
        $user->password =bcrypt( $request->input('password'));       
        $user->save();
        if($request->input('roles')){
           foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }
    }
    return  response(User::with('roles')->find($user->id));

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
    	
    	return User::with('roles')->find($id);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function profile($id) {        
        $user = User::findOrFail($id);
        return view('admin.profile')->with('user', $user);
    }

    /**
     * get users who has role writer
     *
     * @param  int  $id
     * @return Response
     */
    public function writers() {        
        $users =  User::whereHas('roles', function($query)
{
     $query->where('name', 'writer');
     $query->orWhere('name', 'counterA');
  
})   
    ->get();
        return response($users);
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
            'username' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'min:6'            
            ]);
          if($validator->fails()){
            return Response::json(['error' => $validator->errors()->getMessages()], 404);
        }

        $user = user::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phonenumber = $request->input('phonenumber');
        if($request->input('password') && $request->input('password') != ""){          
            $user->password =bcrypt( $request->input('password'));
        }

        $user->save();
        $data=$request->all();
        DB::table('role_user')->where('user_id',$id)->delete();
        if($request->input('roles')){    			
           foreach ($request->input('roles') as $key => $value) {
             $user->attachRole($value);
         }
        }
        return   User::with('roles')->find($id);
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
    	
    	$user = user::find($id);
    	if($user)
    		$user->delete();

    	return "user record successfully deleted #" . $request->input('id');
    }
}
