<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Auth::routes();
Route::get('/display', function() {
	return view('display');
});
Route::get('/getqueuedata', 'QueueController@getqueuedata');
Route::group( ['middleware' => 'auth' ], function()
{
	Route::get('/logout', 'Auth\LoginController@logout');
	Route::get('/', 'HomeController@index');
	Route::get('/clients', 'ClientController@index');

	Route::get('/clientsData', 'ClientController@clientsData');
	Route::get('/allclients', [
		'as' => 'allclients',
		'uses' => 'ClientController@clientsData'
		]);
	
	Route::get('/postalcodes', 'ClientController@getPostalCodes');


	Route::get('allroles',['as'=>'roles.index','uses'=>'RoleController@index']);
	Route::get('/allusers',  'UserController@index');
//clients
	Route::get('/clients', function () {
		return view('client/clients');
	});

		//cases
	Route::get('/register', function () {
		return view('/client/register');
	});

	Route::resource('clients', 'ClientController',['except' => [
		'index']]);		
	Route::get('/allclients',  'ClientController@index');
	Route::get('/checkNRIC', 'ClientController@checkNRIC');	
	Route::get('/getClientbyNRIC/{nric}', 'ClientController@getClientbyNRIC');	
	Route::get('/client/{id}',  'ClientController@getClient');
	Route::post('/updateRegister',  'ClientController@updateRegister');
	Route::post('/updateRegister/{id?}',  'ClientController@updateRegister');
		//Queue
	Route::get('/mpqueue', function() {
		return view('queue');
	});
	Route::get('/writerqueue', function() {
		return view('queue');
	});
	
	Route::post('/queue',  'QueueController@addQueue');
	Route::get('/queues',  'QueueController@index');
	Route::get('/updateQueue/{status}/{id}',  'QueueController@updateQueue');
	Route::get('/callQueue/{queueid}/{id?}',  'QueueController@callQueue');
	Route::get('/getNextQueueId/{queueid}',  'QueueController@getNextQueueId');
		//cases
	Route::get('/cases', function () {
		return view('/case');
	});
	Route::get('/allcases',  'CaseController@index');
	Route::get('/caseStatus/{case_id}',  'CaseController@caseStatus');
	Route::post('/savecaseStatus', 'CaseController@savecaseStatus');
	Route::delete('/deleteStatus/{id}', 'CaseController@deleteStatus');
	Route::post('/savecaseFile', 'CaseController@savecaseFile');
	Route::get('/case?clientId={client_id}', function($client_id) {
		return view('case',compact('client_id',$client_id));
	});
	Route::get('/checkOrganization/{subject?}', 'CaseController@checkOrganization');
	Route::post('/cases', 'CaseController@store');		
	Route::post('/cases/{id}', 'CaseController@update');
	Route::delete('/cases/{id}', 'CaseController@destroy');
	Route::get('/cases/{id}', 'CaseController@getCase');
	Route::get('/getCases/{queue_id}', 'CaseController@getCases');
		//case references
	Route::get('/caseReferences', function () {
		return view('admin/caseReference');
	});
	Route::get('/allcaseReferences',  'CaseReferenceController@index');
	Route::get('/caseReference/{id}',  'CaseReferenceController@show');
	Route::get('/checkcaseReference/{description?}', 'CaseReferenceController@checkcaseReference');
	Route::post('/caseReferences', 'CaseReferenceController@store');		
	Route::post('/caseReferences/{id}', 'CaseReferenceController@update');
	Route::delete('/caseReferences/{id}', 'CaseReferenceController@destroy');
	Route::get('/getcaseRefCounterA', 'CaseReferenceController@getcaseRefCounterA');

	Route::get('/setCurrent', 'QueueController@setCurrent');
	Route::get('/writers',  'UserController@writers');

	Route::get('/allapprovalparties',  'ApprovalpartyController@index');
	Route::get('/defaultapprovalparty',  'ApprovalpartyController@getDefault');
	Route::get('/allaccomodations',  'AccomodationController@index');
	Route::get('/alltemplates',  'TemplateController@index');
	Route::get('/allrecipients',  'RecipientController@index');
	Route::get('/getAccomodationTypes/{type}',  'AccomodationController@getAccomodationTypes');
	Route::get('/profile/{id}',  'UserController@profile');

	Route::get('/template/{id}',  'TemplateController@show');

	Route::get('/defaultApprovalParty/{id}',  'ApprovalpartyController@setdefault');

	Route::group(['middleware' =>  ['role:admin|counterA|mp']], function() {
	//Counter A Queue
	Route::get('/counterqueue', function() {
			return view('queue');
		});
});	
	Route::group(['middleware' => ['role:admin']], function() {
		Route::get('/users', function () {
			return view('admin/user');
		});
		Route::get('/roles', function () {
			return view('admin/role');
		});		
		
		Route::get('/user/{id}',  'UserController@show');
		
		Route::post('/users', 'UserController@store');
		Route::get('/checkUsername/{username?}', 'UserController@checkUsername');
		Route::post('/users/{id}', 'UserController@update');
		Route::delete('/users/{id}', 'UserController@destroy');
		
		Route::get('/accommodations', function () {
			return view('admin/accomodation');
		});
		
		
		Route::get('/accomodation/{id}',  'AccomodationController@show');
		Route::post('/accomodations', 'AccomodationController@store');
		Route::get('/checkRoomType/{roomtype?}', 'AccomodationController@checkRoomType');
		Route::post('/accomodations/{id}', 'AccomodationController@update');
		Route::delete('/accomodations/{id}', 'AccomodationController@destroy');
		Route::get('/approvalparties', function () {
			return view('admin/approvalParty');
		});
		
		Route::get('/approvalparty/{id}',  'ApprovalpartyController@show');		
		Route::post('/approvalparties', 'ApprovalpartyController@store');		
		Route::post('/approvalparties/{id}', 'ApprovalpartyController@update');
		Route::delete('/approvalparties/{id}', 'ApprovalpartyController@destroy');

		Route::get('/templates', function () {
			return view('admin/template');
		});
		
		
		Route::get('/checkSubject/{subject?}', 'TemplateController@checkSubject');
		Route::post('/templates', 'TemplateController@store');		
		Route::post('/templates/{id}', 'TemplateController@update');
		Route::delete('/templates/{id}', 'TemplateController@destroy');
		//recipients
		Route::get('/recipients', function () {
			return view('admin/recipient');
		});
		
		Route::get('/recipient/{id}',  'RecipientController@show');
		Route::get('/checkOrganization/{subject?}', 'RecipientController@checkOrganization');
		Route::post('/recipients', 'RecipientController@store');		
		Route::post('/recipients/{id}', 'RecipientController@update');
		Route::delete('/recipients/{id}', 'RecipientController@destroy');

			//reports
		Route::get('/reportB', function () {
			return view('report/reportB');
		});
		Route::get('/reportB/{quarter}/{year}', 'ReportController@reportB');
		Route::get('/reportA/{startDate}/{endDate}', 'ReportController@reportA');
		Route::get('/reportA', function () {
			return view('report/reportA');
		});
		Route::get('pdfviewA',array('as'=>'pdfviewA','uses'=>'ReportController@downloadFormA'));
		Route::post('/saveformA', 'ReportController@formASave');
		Route::get('pdfviewB',array('as'=>'pdfviewB','uses'=>'ReportController@downloadFormB'));
		Route::post('/saveformB', 'ReportController@formBSave');
	});	
});
// Templates
Route::group(array('prefix'=>'/templates/'),function(){
	Route::get('{template}', array( function($template)
	{
		$template = str_replace(".html","",$template);
		View::addExtension('html','php');
		return View::make('templates.'.$template);
	}));
});