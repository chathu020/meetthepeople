@extends('layouts.blank')
@section('styles')
@parent
<!-- Example -->
<link href="{{ asset("css/custom.css") }}" rel="stylesheet">
<link href="{{ asset("css/select2.css") }}" rel="stylesheet">
<link href="{{ asset("css/selectize.default.css") }}" rel="stylesheet">
<link href="{{ asset("css/select.css") }}" rel="stylesheet">

@stop
@section('main_container')

<div class="right_col" role="main" style="min-height: 1000px;"  ng-app="application">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
  <div class="page-title">
    <div class="title_left">
      <h3>Clients <small>Management</small></h3>
      <hr> 
  </div>
</div>

<div class="clearfix"></div>
  <div  ng-controller="clientsController">
<div class="container"> 
    <div class="row">
         <form name="clientForm" class="form-horizontal" novalidate="">
          <div class="control-group" ng-class="{true: 'error'}[submitted && clientForm.nric.$invalid]">
         <fieldset>
           <legend>Personal Particulars</legend>
           <!-- NRIC -->   
           <div class="form-group row">
            <label for="nric" class="col-md-2 control-label">NRIC *</label>      
            <div class="col-md-4">
              <input type="text" ng-required="true" class="form-control " ng-class="{ errorinput: submitted && clientForm.nric.$invalid }"  ng-change="loadClient()" ng-model="client.nric" id="nric" name="nric"  value="@{{client.nric}}" >
               <span class="help-inline" style="color:red"
                        ng-show="clientForm.nric.$touched && clientForm.nric.$invalid">@{{message}}</span>
            </div>
            <label for="race" class="col-md-2 control-label">Race</label>  
            <div class=" col-md-4">    
                <div class="form-check form-check-inline">  
                 <input type="radio" name="race" id="optionC" ng-model="client.race"  class="form-check-input" value="C">  
                     <label for="optionC" class="form-check-label">C</label>  
                   
                </div>
                <div class="form-check form-check-inline">                    
                     <input type="radio" name="race" id="optionM" ng-model="client.race"  class="form-check-input" value="M">  
                    <label for="optionM" class="form-check-label">M</label>  
                </div>
                <div class="form-check form-check-inline">                    
                   <input type="radio" name="race" id="optionI" ng-model="client.race"  class="form-check-input" value="I"> 
                     <label for="optionI" class="form-check-label">I</label>  
                </div>
                <div class="form-check form-check-inline">                    
                    <input type="radio" name="race" id="optionOther" ng-model="client.race"  class="form-check-input" value="Other"> 
                     <label for="optionOther" class="form-check-label">Other</label>  
                </div>
            </div>
        </div>

        <!-- Name -->
        <div class="form-group row">
            <label for="name"  class="col-md-2 control-label">Name *</label>  
            <div class="col-md-4">
                   <input type="text" ng-class="{ errorinput: submitted && clientForm.name.$invalid }"  ng-required="true" class="form-control" ng-model="client.name" id="name" name="name"  value="@{{client.name}}" >  
                    <span class="help-inline" style="color:red"
                        ng-show="clientForm.name.$touched && clientForm.name.$invalid">Enter a valid name</span>            
            </div>
            <label for="birthday" class="col-md-2 control-label">Birthday *</label> 
            <div class="col-md-4">
                <input type="date" class="form-control" ng-class="{ errorinput: submitted && clientForm.dateOfBirth.$invalid }" ng-required="true" max="@{{maxdate | date:'yyyy-MM-dd'}}" ng-model="dateOfBirth" id="dateOfBirth" name="dateOfBirth"  value="@{{dateOfBirth  | date:'yyyy-MM-dd'}}"   >      
                 <span class="help-inline" style="color:red"
                        ng-show="clientForm.dateOfBirth.$invalid && clientForm.dateOfBirth.$touched">Enter a valid Birthday</span>          
            </div>
        </div>

        <div class="form-group row">
            <label for="sex" class="col-md-2 control-label">Gender</label>           
            <div class=" col-md-4">    
                <div class="form-check form-check-inline">  
                  <input type="radio" name="sex" id="male" ng-model="client.sex"  class="form-check-input" value="male">    
                   <label for="male" class="form-check-label">Male</label>  
                </div>
                <div class="form-check form-check-inline">                    
                    <input type="radio" name="sex" id="female" ng-model="client.sex"  class="form-check-input" value="female">  
                    <label for="female" class="form-check-label">Female</label>  
                </div>
            </div>
            <label for="color" class="col-md-2 control-label">NRIC Type</label>             
            <div class=" col-md-4">    
                <div class="form-check form-check-inline">  
                <input type="radio" name="color" id="pink" ng-model="client.color"  class="form-check-input" value="pink">                   
                   <label for="pink" class="form-check-label">Pink</label>  
                </div>
                <div class="form-check form-check-inline">  
                <input type="radio" name="color" id="blue" ng-model="client.sex"  class="form-check-input" value="blue"> 
                    <label for="blue" class="form-check-label">Blue</label>  
                </div>
            </div>
        </div>

    </fieldset>   

    <fieldset> 
        <legend>Address</legend>

        <!-- blkNo --> 
        <div class="col-md-6">  
        <div class="form-group row">
            <label for="blkNo"  class="col-md-4 control-label">Block No *</label>  
                     <div class="col-md-8">
                    <input type="text" class="form-control" ng-class="{ errorinput: submitted && clientForm.blkNo.$invalid }" ng-required="true" ng-model="client.blkNo" id="blkNo" name="blkNo"  value="@{{client.blkNo}}" > 
                     <span class="help-inline" style="color:red"
                        ng-show="clientForm.blkNo.$invalid && clientForm.blkNo.$touched">Enter a valid Block No</span>  
            </div>
         
        </div>


        <!-- Address -->
        <div class="form-group row">
            <label for="address" class="col-md-4 control-label">Street Name *</label>
            <div class="col-md-8">
                <textarea rows="3" ng-class="{ errorinput: submitted && clientForm.address.$invalid }" class="form-control" ng-required="true"  ng-model="client.address" id="address" name="address"  value="@{{client.address}}"></textarea>
                  <span class="help-inline" style="color:red"
                        ng-show="clientForm.address.$invalid && clientForm.address.$touched">Enter a valid Street Name</span>
            </div>
      
</div>
<!-- Unit No -->   
<div class="form-group row">
    <label for="unitNo" class="col-md-4 control-label">Unit No</label>     
    <div class="col-md-8">
                <input type="text" class="form-control"   ng-model="client.unitNo" id="unitNo" name="unitNo"  value="@{{client.unitNo}}" >                 
    </div>
</div>

<!-- Postal Code -->   
<div class="form-group row">
    <label for="postalCode" class="col-md-4 control-label">Postal Code *</label> 
        <div class="col-md-7">
              <input type="text" ng-class="{ errorinput: submitted && clientForm.postalCode.$invalid }" class="form-control" ng-required="true" ng-model="client.postalCode" id="postalCode" name="postalCode"  value="@{{client.postalCode}}" ng-change="validatePostalcode()" >
               <span class="help-inline" style="color:red"
                        ng-show="clientForm.postalCode.$invalid && clientForm.postalCode.$touched">Enter a valid Postal Code</span>
    </div>
     <div class="col-md-1">
    <div id="postalvalid-box"  class="square blue"></div> 
    <div ng-if="zone != null && zone != ''" class="square green">@{{zone}}</div>
    </div>
</div>
</div>
      <div class="col-md-6">
<div class="form-group row">
           <label for="accomodationType" class="col-md-4 control-label">Accommodation</label>        
            <div class=" col-md-8">    
                <div class="form-check form-check-inline">  
                <input type="radio" name="accomodationType" ng-change="accommodationChange(client.accomodationType)" id="blue" ng-model="client.accomodationType"  class="form-check-input" value="Hdb"> 
                 <label for="hdb" class="form-check-label">HDB</label>  
                 </div>
                <div class="form-check form-check-inline">
                   <input type="radio" name="accomodationType" ng-change="accommodationChange(client.accomodationType)" id="optionprivate" ng-model="client.accomodationType"  class="form-check-input" value="Private">
                   <label for="optionprivate" class="form-check-label">Private</label>
                </div>
            </div>
</div>
<div class="form-group row">
                <label for="roomType" class="col-md-4 control-label">Type *</label>               
              <div class=" col-md-8"> 
              <select class="form-control" ng-class="{ errorinput: submitted && clientForm.roomType.$invalid }" name="roomType" ng-required="true" ng-model="client.roomType" ng-options=" acc.id as acc.roomType for acc in accomodationTypes"> 
            <option value="" disabled>Please choose Accomodation Type</option>
          </select>   
            <span class="help-inline" style="color:red"
                        ng-show="clientForm.roomType.$invalid && clientForm.roomType.$touched">Enter a valid Accommodation Type</span>
           
            </div>
          </div>
          <div class="form-group row">
            <div class=" col-md-12"> 
             <div class=" row"> 
                <label for="status" class="col-md-4 control-label">Status</label> 
               <div class="col-md-8">
                <div class="form-check form-check-inline ">      
                <input type="radio" name="status" id="optionown" ng-model="client.status"  class="form-check-input" value="own">              
              <label for="optionown" class="form-check-label">Own</label> 
                </div>
                <div class="form-check form-check-inline">
                <input type="radio" name="status" id="rented" ng-model="client.status"  class="form-check-input" value="rented">              
              <label for="rented" class="form-check-label">Rented</label> 
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
</fieldset>

<fieldset>

    <legend>Contacts</legend>
     <!-- No Contacts --> 
   
        <div class="col-md-6"> 
       <div class="form-group row">
        <div class="col-md-11"> 
        <label for="noContact" class="col-md-4 control-label">No Contacts</label> 
        
              <input ng-model="client.noContact" style=" margin-left: 10px;margin-top: 10px;"
              type="checkbox" id="noContactbox" ng-click="handleNoContact()"
              name="noContact"
              value="@{{client.noContact}}"             
              >         
        </div>
        <div class="col-md-1">       
           <div class="prefer">   Preferred?</div>
       </div>
   </div>
    <div class="row">
     <div class="col-md-11"> 
      

   <!-- handphone -->   
   <div class="form-group row">
    <label for="handphone" class="col-md-4 control-label">Mobile No</label>      
    <div class="col-md-8">
         <input type="text" only-digits class="form-control  no-spinners" ng-model="client.handphone" id="handphone" name="handphone"  value="@{{client.handphone}}" >
   
    </div>
   
</div>

<!-- officeTel -->   
<div class="form-group row">
    <label for="officeTel" class="col-md-4 control-label">Office Tel No</label>    
    <div class="col-md-8">
        <input type="text" only-digits class="form-control  no-spinners" ng-model="client.officeTel" id="officeTel" name="officeTel"  value="@{{client.officeTel}}" >      
    </div> 
</div>

<!-- homeTel -->   
<div class="form-group row">    
   <label for="homeTel" class="col-md-4 control-label">Home Tel No</label>
    <div class="col-md-8"> 
       <input type="text" only-digits class="form-control  no-spinners" ng-model="client.homeTel" id="homeTel" name="homeTel"  value="@{{client.homeTel}}" >  
    </div>   
</div>
<!-- pagerNo -->   
<div class="form-group row">
     <label for="email" class="col-md-4 control-label">Email</label>
    <div class="col-md-8">
         <input type="email" class="form-control  no-spinners" ng-model="client.email" id="email" name="email"  value="@{{client.email}}" >  
         <span class="help-inline"  style="color:red"
                        ng-show="clientForm.email.$invalid ">Valid Email field is required</span>    
    </div>   
</div>
<span class="help-inline"  style="color:red"
                        ng-show="contactinvalid">At Least one Contact method is required</span>  
</div>
<div class="col-md-1 ">       
           <div class="form-group row" ng-repeat="prefer in prefers"> 
              <input style="margin-bottom:15px;"
              type="checkbox"
              name="selectedprefers[]"
              value="@{{prefer}}"
              ng-checked="selectedprefers.indexOf(prefer) > -1"
              ng-click="toggleSelection(prefer)"   
              > 
          </div> 
          
</div>
            
       </div>
       </div>


<div class="col-md-6"> 
   <!-- No Contacts -->   
   <div class="form-group row">
    <label for="language" class="col-md-4 control-label">Language</label> 
    <div class="col-md-8">     
            
        <div class="form-check form-check-inline" ng-repeat="prefer in languages" >                    
            <input
              type="checkbox"
              name="selectedlanguage[]"
              value="@{{prefer| lowercase}}"
              ng-checked="selectedlanguage.indexOf('@{{prefer| lowercase}}') > -1"
              ng-click="toggleLanguage(prefer)"   
              > @{{prefer}}
        </div>    
</div>
</div>
<div class="form-group row">
    <label for="notes" class="col-md-4 control-label">Notes</label>  
    
    <div class="col-md-8">
       <textarea rows="2" class="form-control" ng-model="client.notes" id="notes" name="notes"  value="@{{client.notes}}"></textarea>
    </div>
</div>
<div class="form-group row">
    <label for="notes" class="col-md-4 control-label">Information</label>  
     <div class="col-md-8">
    <div class="form-check form-check-inline" >                    
            <input
              type="checkbox"
              name="resident[]" ng-checked="resident.indexOf('agency') > -1"
              value="agency"    ng-click="toggleResident('agency')"
              > Resident consent to release information to relevant agencies
        </div>
        <div class="form-check form-check-inline"  >                    
            <input
              type="checkbox"
              name="resident[]" ng-checked="resident.indexOf('whampoa') > -1"
              value="whampoa" ng-click="toggleResident('whampoa')"
              > Resident consent to receive information from Whampoa PAP
        </div>
          </div>
</div>
<br> 
<div class="form-group row" ng-show="modalstate == 1">
    <div class="col-md-8">
      <select ng-model="casereference" class="form-control" ng-options="case.id as case.description for case in caseReferences">
                <option value="">Select Case Reference</option>               
              </select>
</div>
<div class="col-md-4">
     <button class="btn btn-info btn-detail" ng-click="addQueue(client.nric,casereference)"><i class="fa fa-wrench fa-fw"></i>Add Queue</button>
</div>
</div>  

</div>

</fieldset>

<!-- Submit Button -->
<br>
<div class="form-group row">   
         <button click="cancelRegister()" style="margin-left: 5px"  class="btn btn-default pull-right"> Cancel  </button >      
         <button type="button" style="margin-left: 5px" class="btn btn-primary pull-right" id="btn-save" ng-click="save(client.id)" ><i class="fa fa-save fa-fw"></i> Add/Update </button>
          @role(([ 'admin', 'mp']))
         <button class="btn btn-danger btn-delete pull-right" ng-show="modalstate == 1" ng-click="confirmDelete(client.id)"><i class="fa fa-trash fa-fw"></i> Delete </button>
          @endrole
    
</div>
</div>
</form>
<br>
</div>

</div>

<!-- Queue added-->
<div class="modal fade" id="queue-case"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       Queue Added 
      </div>
      <div class="modal-body centerText" style="font-size: 18px;">You have added to Queue!  <br>
        Queue No: <span id="queueno" style="font-weight: bold;"> </span>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"  >OK</button>
        
      </div>
    </div>
  </div>
</div>
</div>
</div>
@stop


@section('scripts')
@parent
<script src="{{ asset("js/helper.js") }}"></script>
<script src="{{ asset("js/angular.min.js") }}"></script> 
<script src="{{ asset("js/angular-route.min.js") }}"></script>
<!-- load angular -->
<script src="{{ asset("js/angular-spinners.min.js") }}"></script>
<!-- AngularJS  Scripts -->
<script src="{{ asset("js/app/packages/dirPagination.js") }}"></script>
<script src="{{ asset("js/app/helper.js") }}"></script>
<script src="{{ asset("js/app/app.js") }}"></script>
<script src="{{ asset("js/app/controllers/client.js") }}"></script>


@stop