<?php

namespace App\Http\Controllers;
use App\Models\CaseFile;
use App\Models\Casestatus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Support\Facades\File;
class CaseController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Case Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new cases as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    /**
     * Where to redirect cases after login / registration.
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
            $items = CaseFile::with('client')->where("clientCaseRefHead", "LIKE", "%{$request->get('search')}%")->orWhere("subject", "LIKE", "%{$request->get('search')}%")
            ->orWhere("nric", "LIKE", "%{$request->get('search')}%")
                       ->orWhere("name", "LIKE", "%{$request->get('search')}%") ->get();//paginate(20);      
                   }else{
                    if( $request->has('clientId')){              
                        $items = DB::select( DB::raw('SELECT cases.*, cl.name, cl.nric, cs.status FROM cases join clients cl on cases.client_id = cl.id left join (select cs.* from casestatus cs, (SELECT c.case_id, max( c.created_at) as created_at FROM casestatus c group by c.case_id) a where cs.case_id=a.case_id and cs.created_at = a.created_at) cs on cases.id = cs.case_id where cases.client_id = :client_id'),
                            array(':client_id'=> $request->input('clientId')));
                    }else{
                    $items = DB::select( DB::raw('SELECT cases.*,cl.name, cl.nric, cs.status FROM cases join clients cl on cases.client_id = cl.id left join (select cs.* from casestatus cs, (SELECT c.case_id, max( c.created_at) as created_at FROM casestatus c group by c.case_id) a where cs.case_id=a.case_id and cs.created_at = a.created_at) cs on cases.id = cs.case_id'),
                            array());     
            }
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
            'clientCaseRefHead' => 'required|max:255'
            ]);
           if($validator->fails()){
            return Response::json(['error' => $validator->errors()->getMessages()], 404);
        }
        $request['approvedBy_id'] =  $request->input("approvedBy_id") == "" ? null : $request->input("approvedBy_id");
        $request['caseRef_id'] =  $request->input("caseRef_id") == "" ? null : $request->input("caseRef_id");            
        $request['writer_id'] =  $request->input("writer_id") == "" ? null : $request->input("writer_id");

        if($request['recipient_id'] == "")   
            $request['recipient_id']= null; 
        $input = $request->all();   
        $case = CaseFile::create($input);             
        return  response($case);

    } catch (Exception $e) {
      return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
  }       
}


    /**
     * Get the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getCase($id) {   
        $caseFile =CaseFile::with('client.accommodation')->where('id', $id)->first();
        return response($caseFile);   
    }

    public function getCases($queue_id) {    

        $caseFiles = CaseFile::where('queueno',$queue_id)->get();          
        return response($caseFiles);

    }

    public function caseStatus($case_id) {    

        $caseStatus = Casestatus::where('case_id',$case_id)->get();          
        return response($caseStatus);

    }

    public function savecaseStatus(Request $request) {    

        try{
            $input = $request->all();  
            $caseStatus = Casestatus::create($input); 
            return  response($caseStatus);

        } catch (Exception $e) {
          return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
      }     

  }

  public function deleteStatus($id) {    
    try{
        $caseStatus = Casestatus::find($id);
        if($caseStatus){
            try{
                $data = explode( '/images/Uploads/', $caseStatus->filename );                
                $file_path = public_path().'/images/Uploads/' .$data[1];
                if(File::exists($file_path)){
                    File::delete($file_path); 
                }            
            }catch(Exception $e){}            
            $caseStatus->delete();
        }  
        return "case record successfully deleted #" . $id;
    } catch (Exception $e) {
      return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
  }  
}

public function savecaseFile(Request $request){
 try{    

     $input = $request->all();     

      if (empty($_FILES)){ //the file size exceeds max size uploadable

         $max_size =$this->parse_size(ini_get('post_max_size'));
         $upload_max = $this->parse_size(ini_get('upload_max_filesize'));
         if ($upload_max > 0 && $upload_max < $max_size) {
          $max_size = $upload_max;
      }
      $file_upload_max_size = $max_size; 
      return "size".$file_upload_max_size;
  }
  if ($request->hasFile('file'))
  {
     $file =$request->file('file');       
         if (!$file->isValid()){ // now check if it's valid
         return Response::json(['error' => $file->getErrorMessage()], 404); 
     }

     $name=  $file->getClientOriginalName();
     $imageName = pathinfo($name, PATHINFO_FILENAME);
     $extension = pathinfo($name, PATHINFO_EXTENSION);
     $i =1;
     while(file_exists(public_path() . '/images/Uploads/'.$imageName.'.' .$extension)){//validate file name whether already has the same name
        $imageName = pathinfo($name, PATHINFO_FILENAME).'_'.$i;
        $i++;
    }
    $request->file('file')->move(public_path() . '/images/Uploads', $imageName.'.' .$extension);
    $caseStatus = Casestatus::findOrFail($request->input("id"));
    $caseStatus->filename =url('/').'/images/Uploads/'.$imageName.'.' .$extension;
    $caseStatus->save();
    return $caseStatus;
}

} catch (Exception $e) {
  return Response::json(['error' => 'Error occurred. Please contact administrator!'], 404);
}  
}

public function parse_size($size) {
  $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
  $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
  if ($unit) {
    // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
    return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
}
else {
    return round($size);
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
            $case = CaseFile::findOrFail($id);

            $this->validate($request, [
                'clientCaseRefHead' => 'required'             
                ]);            
            $request['approvedBy_id'] =  $request->input("approvedBy_id") == "" ? null : $request->input("approvedBy_id");
            $request['caseRef_id'] =  $request->input("caseRef_id") == "" ? null : $request->input("caseRef_id");            
            $request['writer_id'] =  $request->input("writer_id") == "" ? null : $request->input("writer_id");

            if($request['recipient_id'] == "")   
                $request['recipient_id']= null; 
            $input = $request->all();             
            $case->fill($input)->save();                
            
            return response($case);
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

        $case = CaseFile::find($id);
        if($case)
            $case->delete();

        return "case record successfully deleted #" . $request->input('id');
    }
}
