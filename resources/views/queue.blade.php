@extends('layouts.blank')
@section('styles')
@parent
<!-- Example -->
<link href="{{ asset("css/custom.css") }}" rel="stylesheet">
<link href="{{ asset("css/jquery.spellchecker.css") }}" href="" />
<link href="{{ asset("css/select2.css") }}" rel="stylesheet">
<link href="{{ asset("css/selectize.default.css") }}" rel="stylesheet">
<link href="{{ asset("css/select.css") }}" rel="stylesheet">
@stop

@section('main_container')

<div class="right_col" role="main" style="min-height: 4140px;" ng-app="application">

  <div class="page-title">
    <div class="title_left">
      <h3>Queues <small>Management</small></h3>
      <hr> 
    </div>
  </div>
  <div class="clearfix"></div>


  <div class="container">
    <div  ng-controller="queuesController">
      <div class="row">
        <div class="col-xs-12 pull-left">
          <button id="btn-add" class="btn btn-primary btn-xs" ng-click="refresh()"><i class="fa fa-refresh fa-fw"></i>Refresh</button>
        </div>    
      </div>
      <div class="row">
        <div class="col-xs-8 pull-left">
         <div class="form-inline" style="display: inline-table">
          <label>Start Date</label><input type="date" class="form-control" style="margin: 10px" ng-model="startDate"> <span ></span>
          <label>End Date</label><input type="date" class="form-control" style="margin: 10px" ng-model="endDate" ng-change='checkDateRange(startDate,endDate)'> 
        </div>              
      </div>
      <div class="col-xs-2" style="margin-top: 20px;">
    <label>Residents in Queue:   @{{filtered.length}}</label> 
        </div>
      <div class="col-xs-2 pull-right" style="margin-top: 20px;">
         <div ng-show="(queue_id == 1 && mpAdmin) || ((queue_id == 0 || queue_id == 2) && (counterWriter || mpAdmin))"> 
        <div ng-show=" next  != null && next != ''" >
        <button  id="btn-add" class="btn btn-primary btn-xs" ng-click="callNext(-1)"><i class="fa fa-phone fa-fw"></i>Call Next Number </button> <strong>@{{next}}</strong>
        </div>
      </div>
    </div>
    </div>
    <div class="row">
     <div class="col-md-12 table-responsive customtable">

     <div class="row"> <div class="loading"><spinner show="loading" name="mySpinner" img-src='{{ asset("images/gear.gif") }}' ></spinner></div></div>
      <table class="table">
        <thead>
          <tr>
            <th ng-click="sort('queueno')">Queue
              <span class="glyphicon sort-icon" ng-show="sortBy=='queueno'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th>
            <th ng-click="sort('created_at')">Date
              <span class="glyphicon sort-icon" ng-show="sortBy=='created_at'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th>
            <th ng-click="sort('nric')">NRIC
              <span class="glyphicon sort-icon" ng-show="sortBy=='nric'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th>
            <th ng-click="sort('name')">Name
              <span class="glyphicon sort-icon" ng-show="sortBy=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th> 
            <th></th>  
            <th ng-click="sort('status')">Status
              <span class="glyphicon sort-icon" ng-show="sortBy=='status'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th> 
            <th colspan="3">Action</th>            
          </tr>
        </thead>
        <tbody>
          <tr dir-paginate="queue in (filtered =( queues | dateRange : startDate : endDate | filter: searchText| orderBy:sortBy:reverse))| itemsPerPage: pageSize" pagination-id="queue-table" current-page="currentPage">
            <td>@{{queue.queueno}}</td>
            <td>@{{ formatDate(queue.created_at ) | date:'MM/dd/yyyy'}}</td>
            <td>@{{  queue.nric }}<div ng-if="queue.zone != null && queue.zone != ''" class="square green pull-right">@{{queue.zone}}</div><div ng-if="queue.color == '1'" class="square blue pull-right">PR</div> <div ng-if="queue.color == '0'"  class="square pink pull-right">SG</div> </td>
            <td>@{{ queue.name }}</td> 
            <td><div ng-if="queue_id == '1' && queue.casecount > 1"  class="square orange pull-left">@{{queue.casecount}}</div>
              <label class="label label-success label-padding" ng-repeat="display in queue.language.split(',') ">@{{ display }}</label></td>
            <td>@{{ queue.status }}</td>  
            <td>                 
              <div ng-show="(queue_id == 1 && mpAdmin) || ((queue_id == 0 || queue_id == 2) &&  (counterWriter || mpAdmin))">              
              <button ng-if="  modalstate == 'add' || modalstate=='counterA' " class="btn btn-primary btn-xs btn-detail" ng-click="addCaseFile(queue)"><i class="fa fa-wrench fa-fw"></i>Add Case </button>
              <button ng-if=" modalstate == 'edit' " class="btn btn-primary btn-xs btn-detail" ng-click="editCaseFile(queue)"><i class="fa fa-pencil fa-fw"></i>Edit Case </button>                 
              </div>
            </td> 
            <td>  <div ng-show="(queue_id == 1 && mpAdmin) || ((queue_id == 0 || queue_id == 2) &&  (counterWriter || mpAdmin))">  
                <button  id="btn-add" class="btn btn-primary btn-xs" ng-click="callNext(queue.id)"><i class="fa fa-phone fa-fw"></i>Call This Queue</button>  
                 </div>
            </td>  
            <td>
               <div ng-show="(queue_id == 1 && mpAdmin) || ((queue_id == 0 || queue_id == 2) && (counterWriter || mpAdmin))">  
              <div ng-if=" queue.status == 'Available' && (queue_id == '0' ||queue_id == '1')  ">
                <button class="btn btn-info btn-xs btn-detail" ng-click="setPending(queue)"><i class="fa fa-edit fa-fw"></i>Pending</button>
              </div>            
              </div>              
            </td>    
          </tr>
        </tbody>
      </table>

      <dir-pagination-controls class="pull-right" pagination-id="queue-table" on-page-change="pageChanged(newPageNumber)" template-url="/templates/dirPagination.html" ></dir-pagination-controls>

      <!-- End of Table-to-load-the-data Part -->
      <!-- Modal (Pop up when detail button clicked) -->
      <div class="modal fade" id="caseModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-modal-index="1">
        <div class="modal-dialog modal-lg" style ="margin-top: 0px;">
          <div class="modal-content">
            <div class="modal-header">     
             <button type="button" class="close" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>            
             <h4 class="modal-title" id="myModalLabel">@{{form_title}}</h4>
           </div>
           <div class="modal-body" >
            <form name="formCase" class="form-horizontal" novalidate="">
              <fieldset>               
               <label for="name" class="col-sm-2 control-label">Name</label>
               <div class="col-sm-4">
                <input type="text" class="form-control" id="queuename" name="name"  value="@{{client.name}}" readOnly = true
                >
              </div>
              <div class="form-group">
                <label for="nric" class="col-sm-2 control-label">NRIC</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="nric" name="nric"  value="@{{client.nric}}" readOnly = true
                  >
                </div>
              </div>


            </fieldset>           
            <fieldset>            
              <div class="form-group">
               <label for="roomType" class="col-sm-2 control-label">Description *</label>
               <div class="col-sm-4">
                 <select class="form-control" ng-required="true" ng-class="{ errorinput: submitted && formCase.caseRef_id.$invalid }" name="caseRef_id"  ng-model="caseFile.caseRef_id" ng-options=" case.id as case.description for case in caseReferences" >                    
                  <option value="" disabled>Select Case Reference</option>
                </select>
              </div>
              <div ng-show="(queue_id == '0' || queue_id == '1') " >

                <label for="refNo" class="col-sm-2 control-label">Your Ref No</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" ng-model="caseFile.refNo" id="refNo" name="refNo"  value="@{{caseFile.refNo}}"  
                  >
                </div> 
              </div>  
            </div> 
          </fieldset> 
          <div ng-show="(queue_id == '0' ||queue_id == '1') " >



           <div class="form-group">
            <label for="recipient_id" class="col-sm-2 control-label">Recipient</label>
            <div class="col-sm-4">
                <ui-select ng-model="caseFile.recipient_id" ng-class="{ errorinput: submitted && formCase.recipient_id.$invalid }" name="recipient_id" id="recipient_id" ng-change="updateRecipientData()"  >
         <ui-select-match>
         <span ng-bind="$select.selected.organization"></span>
       </ui-select-match>
       <ui-select-choices ui-disable-choice="re.id == null" repeat="re.id as  re in  (recipients | filter: $select.search) track by re.id">
       <span ng-bind="re.organization"></span>        
     </ui-select-choices>
   </ui-select>

            </div> 

            <label for="recipient_Salutation" class="col-sm-2 control-label">Salutation</label>
            <div class="col-sm-4">
              <select class="form-control" ng-model="caseFile.recipient_Salutation" ng-options=" x for x in salutations"> 

              </select>

            </div> 
            
          </div>
          
          <div class=" form-group">
            <label for="recipient_Address" class="col-sm-2 control-label">Address</label>
            <div class="col-sm-4">
              <textarea class="form-control" ng-model="caseFile.recipient_Address" n> 

              </textarea>
            </div>
            <label for="attention" class="col-sm-2 control-label">Attention</label>
            <div class="col-sm-4">
              <textarea class="form-control" ng-model="caseFile.attention" n> 

              </textarea>
            </div>
          </div>
          
          <div class="form-group">
            <label for="content" class="col-sm-2 control-label">Fill from templates </label>
            <div class="col-sm-10">
              <button type="button" class="btn btn-info" id="btn-load"  data-toggle="modal" href="#templateModal" ng-click="loadTemplates()" ng-disabled="formQueue.$invalid">Load</button>
            <input type="button" class="btn btn-spell" value="Spell Check" onclick="$Spelling.SpellCheckInWindow('content')" />
            </div>                              
            <div class="modal fade" id="templatesModal"  tabindex="-1" data-focus-on="input:first" data-modal-index="2">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">@{{form_title}}</h4>
                  </div>
                  <div class="modal-body">

                  </div>
                </div>
              </div>
            </div>  
          </div>
          <div class="form-group">
            <label for="subject" class="col-sm-2 control-label">Subject</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" ng-model="caseFile.subject" id="subject" name="subject"  value="@{{caseFile.subject}}"  
              >
            </div>                              

          </div>
          <div class="form-group">
            <label for="content" class="col-sm-2 control-label">Content</label>
            <div class="col-sm-10">
              <textarea rows="5" class="form-control" ng-model="caseFile.content" id="content" name="content"  value="@{{caseFile.content}}"  spellcheck="true"
              ></textarea>
              <div id="incorrect-word-list"></div>

            </div>                              

          </div>

          <div class="form-group">
            <label for="enclosed" class="col-sm-2 control-label">Enclosed</label>
            <div class="col-sm-4">
              <textarea rows="1" class="form-control" ng-model="caseFile.enclosed" id="enclosed" name="enclosed"  value="@{{caseFile.enclosed}}" multiple-emails ></textarea>
              <span class="help-inline" 
              ng-show="formCase.enclosed.$error.multipleEmails ">Please enter correct format of email addresses seperated by comma</span>
            </div> 
            <label for="writer_id" class="col-sm-2 control-label">Writer *</label>
            <div class="col-sm-4">

             <ui-select ng-model="caseFile.writer_id" ng-class="{ errorinput: submitted && formCase.writer_id.$invalid }" id="writer_id"  name="writer_id" ng-required= "!(queue_id == '2')" >
             <ui-select-match>
             <span ng-bind="$select.selected.name"></span>
           </ui-select-match>
           <ui-select-choices ui-disable-choice="writer.id == null" repeat="writer.id as  writer in  (writers | filter: $select.search) track by writer.id">
           <span  ng-bind="writer.name"></span>        
         </ui-select-choices>
       </ui-select>
       <span class="help-inline" 
       ng-show=" formCase.writer_id.$error.uiRequired" >Please enter Writer</span>
     </div>                             
       <!--- <label for="footer" class="col-sm-2 control-label">Footer</label>
        <div class="col-sm-4">

          <label  class="radio-inline">
            <input type="radio" ng-model="caseFile.footer" name="footer" value="Faithfully">
            Faithfully
          </label>
          <label class="radio-inline">
            <input type="radio" name="footer" ng-model="caseFile.footer" value="Sincerely"> Sincerely
          </label>
        </div>-->
      </div>

      <div class="form-group">
        <label for="cc" class="col-sm-2 control-label">Cc</label>
        <div class="col-sm-4">
          <textarea rows="1" class="form-control" ng-model="caseFile.cc" id="cc" name="cc"  value="@{{caseFile.cc}}" multiple-emails></textarea>
          <span class="help-inline" 
          ng-show="formCase.cc.$error.multipleEmails ">Please enter correct format of email addresses seperated by comma</span>
        </div>                              
        <label for="comment" class="col-sm-2 control-label">Comments</label>
        <div class="col-sm-4">
          <textarea rows="2" class="form-control" ng-model="caseFile.comment" id="comment" name="comment"  value="@{{caseFile.comment}}"   ></textarea>
        </div> 
      </div>
      <div ng-show="(queue_id == '1') " >
        <div class="form-group">
          <div class="col-sm-6"></div>
          <label for="approvedBy_id" class="col-sm-2 control-label">Approval By</label>
          <div class="col-sm-4">
            <select class="form-control" ng-model="caseFile.approvedBy_id" ng-options=" ap.id as ap.authorizedName for ap in approvalparties" ng-change="updateApprovalPerson()"> 
              <option value="" disabled>Select Approval Person</option>
            </select>
          </div>

        </div>
      </div>
      <div ng-show="(queue_id == '0' ) " >
        <div class="form-group">
          <div class="col-sm-6"></div>
          <label for="approvedBy_id" class="col-sm-2 control-label">Delivery Mode</label>
          <div class="col-sm-4">

           <div class="form-check form-check-inline" ng-repeat="mode in modes">                    
            <label >
              <input
              type="checkbox"
              name="selectedModels[]"
              value="@{{mode}}"
              ng-checked="selectedModels.indexOf(mode) > -1"
              ng-click="toggleSelection(mode)"   
              > @{{mode}}
            </label>
          </div>
        </div>

      </div>
    </div>
  </div>
  <fieldset> 
   <div class="form-group">
     <label for="created_at" class="col-sm-2 control-label">Date</label>
     <div class="col-sm-4">
      <input type="date" class="form-control" ng-model="caseFile.created_at" id="created_at" name="created_at"  value="@{{caseFile.created_at}}"  readOnly=true
      >
    </div> 



    <label for="clientCaseRefHead" class="col-sm-2 control-label">Client Case Ref No</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="clientCaseRefHead" name="clientCaseRefHead" ng-model="caseFile.clientCaseRefHead" value="@{{caseFile.clientCaseRefHead}}" readOnly = true
      >
    </div>
    <div class="col-sm-1">
     <input type="text" class="form-control" id="clientCaseRefTail" name="clientCaseRefTail" ng-model="caseFile.clientCaseRefTail" value="@{{caseFile.clientCaseRefTail}}" readOnly = true
     >
   </div>

 </div>

 <div class="form-group">
  <label for="accommodation" class="col-sm-2 control-label">Accommodation</label>
  <div class="col-sm-2">
    <input type="text" class="form-control" id="accommodation" name="accommodation"  value="@{{client.accommodation.accomodation}}" readOnly = true
    >
  </div>
  <div class="col-sm-2">
   <input type="text" class="form-control" id="status" name="status"  value="@{{client.status}}" readOnly = true
   >
 </div>
 <label for="roomType" class="col-sm-2 control-label">Room Type</label>
 <div class="col-sm-4">
  <input type="text" class="form-control" id="roomType" name="roomType"  value="@{{client.accommodation.roomType}}" readOnly = true>
</div>
</div>
</fieldset>       

</form>
</div>
<div class="modal-footer">
  <a  class="btn btn-info"  target="_blank"  href="/cases#?clientId=@{{client.id}}" ><i class="fa fa-list fa-fw"></i>Case Files</a> 
  <button ng-if=" queue.status == 'Available'  || queue.status == 'In Progress' && (queue_id == '0' ||queue_id == '1')  " class="btn btn-primary" ng-click="setCasePending()"><i class="fa fa-edit fa-fw"></i>Set Pending</button>
  <button class="btn btn-primary" id="btnPrint" ng-click="printCase()"><i class="fa fa-print"></i> Print</button>
  <button type="button" class="btn btn-primary" id="btn-save" ng-if=" modalstate == 'add' || modalstate == 'counterA' "  ng-click="saveCase()"><i class="fa fa-save fa-fw"></i>Add Case File</button>
      
  <button type="button" class="btn btn-danger" id="btn-delete" ng-if="queue_id == '1' && mpAdmin "   ng-click="deleteCase(queue.id)"><i class="fa fa-trash fa-fw"></i>Void</button>

  <button type="button" class="btn btn-primary" id="btn-status" ng-if="queue_id == '1' " ng-click="showStatus()"><i class="fa fa-info fa-fw"></i>Status</button>
  <button type="button" class="btn btn-primary" ng-if=" modalstate == 'edit' " id="btn-edit"   ng-click="updateCase()"><i class="fa fa-pencil fa-fw"></i>Update Case File</button>
  <button type="button" class="btn btn-default" ng-click="cancel()" >Cancel</button>
</div>
</div>
</div>
</div>
</div>
</div>


<!-- confirm submit -->
<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        Confirm Submit
      </div>
      <div class="modal-body">Your letter added. <br>
        Do you want to submit additional letter?

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" ng-click="nextCase()" >Yes</button>
        <button type="button" class="btn btn-default" ng-click="closeCase()" >No</button>
      </div>
    </div>
  </div>
</div>

<!-- confirm print -->
<div class="modal fade" id="confirm-print" tabindex="1" style="    z-index: 99999" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        Print
      </div>
      <div class="modal-body" id="printbody">
        Do you want to print the added case?

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" ng-click="printCase()" >Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" >No</button>
      </div>
    </div>
  </div>
</div>

<!-- case close -->
<div class="modal fade" id="close-case" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        Confirm Submit
      </div>
      <div class="modal-body">This case closed. <br>
        This queue has additional letters.

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"  >OK</button>
        
      </div>
    </div>
  </div>
</div>

<!-- status submit -->
<div class="modal fade" id="status-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        Status Submit
      </div>
      <div class="modal-body">
        <form name="formCasestaus" class="form-horizontal">

          <div class="form-group">
            <label for="subject" class="col-md-4">Subject *</label>
            <div class="col-md-7">
              <input type="text" class="form-control" ng-class="{ errorinput: statussubmitted && formCasestaus.subject.$invalid }" id="statussubject" name="subject" placeholder="subject" value="@{{subject}}" 
              ng-model="caseStatus.subject" ng-required="true" >
            </div>
          </div>
          <div class="form-group">
           <label for="status" class="col-md-4" >Status</label>
           <div class="col-md-7">
             <label  class="radio-inline">
              <input type="radio" ng-model="caseStatus.status" name="status" value="Success">
              Success
            </label>
            <label class="radio-inline">
              <input type="radio" name="status" ng-model="caseStatus.status" value="Not Success"> Not Success
            </label>
            <label class="radio-inline">
              <input type="radio" name="status" ng-model="caseStatus.status" value="Pending"> Pending
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="status" class="col-md-4" >Image</label>
          <div class="col-md-7">
           <input type="file" id="file" class="form-control"  name="file" accept="image/*" onchange="angular.element(this).scope().getTheFiles(this.files)" ></input>
         </div>
       </div>
       
       <div class="form-group">
        <button type="button" style="margin-left: 5px" class="btn btn-primary" id="btn-save" ng-click="saveStatus()"><i class="fa fa-save fa-fw"></i>Save </button>        
      </div>
    </form>
    <table class="table">
      <thead>
        <tr>
          <th ng-click="sort('created_at')">Date
          </th>
          <th ng-click="sort('subject')">Subject
          </th>    
          <th ng-click="sort('status')">Status
          </th>     
          <th>Image
          </th>
          <th>Action</th>            
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="x in statuses">
          <td>@{{ formatDate(x.created_at ) | date:'MM/dd/yyyy'}}</td>
          <td>@{{ x.subject}}</td>
          <td>@{{ x.status }}</td>
          <td ><a ng-href="@{{x.filename}}" target="_blank">
            <img ng-show="x.filename"  class="status-img" ng-src ="@{{x.filename}}"  attributes="#"></img>
          </a> <a ng-show="x.filename" ng-href="@{{x.filename}}" target="_blank">View</a>
        </td>
        <td>  
          <button class="btn btn-danger btn-xs btn-delete" ng-click="deleteStatus(x.id)"><i class="fa fa-trash fa-fw"></i>Delete</button></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">      
    <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
  </div>
</div>
</div>
</div>

<div class="modal fade" id="templateModal" data-modal-index="2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Templates</h4>
      </div>
      <div class="modal-body">
       <div class="container">
        <div class="col-xs-6">
         <div class="box-tools pull-right" style="display:inline-table">        
          <div class="input-group">
            <input type="text" class="form-control input-sm ng-valid ng-dirty" placeholder="Search" ng-model="searchText"  name="table_search" title="" tooltip="" data-original-title="Min character length is 3">
            <span class="input-group-addon">Search</span>
          </div>                
        </div>
      </div>

      <div class="row">
       <div class="col-xs-12 table-responsive">

        <table class="table" id="templatetable">
          <thead>
            <tr>
              <th ng-click="sort('subject')">Subject
                <span class="glyphicon sort-icon" ng-show="sortByTemplate=='subject'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                <th ng-click="sort('content')">Content
                  <span class="glyphicon sort-icon" ng-show="sortByTemplate=='content'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>   

                </tr>
              </thead>
              <tbody>
                <tr dir-paginate="template in templates | filter: searchText| orderBy:sortByTemplate:reverse | itemsPerPage: pageSize"  pagination-id="template-table" ng-dblclick="keepTemplate(template)" ng-click="loadTemplateData(template)" current-page="currentPage1">
                  <td>@{{  template.subject }}</td>
                  <td>@{{ template.content | limitTo: 50 }} @{{template.content.length  > 50 ? '......' : ''}}</td>

                </tr>
              </tbody>
            </table>
            <dir-pagination-controls class="pull-right"  pagination-id="template-table" template-url="templates/dirPagination.html" ></dir-pagination-controls>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="printThis">
    
  <p>
	  <span><strong>@{{ formatDate(caseFile.created_at ) | date:'dd MMM yyyy'}}</strong></span><br/>
   <span> YOUR REF : </span>@{{caseFile.refNo}}<br/>
    <span>OUR REF : </span> @{{caseFile.clientCaseRefHead}}/@{{caseFile.clientCaseRefTail}}<br/>
      <div class="prelinedata">
       @{{caseFile.attention}}
       @{{caseFile.recipient_Address}}</div><br/>
       <br/>        
       Dear @{{caseFile.recipient_Salutation}}, <br/><br/>
		<strong><span>Subject : </span>@{{caseFile.subject| uppercase}}</strong> <br/>           
       <br/>
       <strong><span >Name : </span>@{{client.name| uppercase}} (NRIC : @{{client.nric| uppercase}})<br/>
		   <span >Address : </span>
        @{{ (client.accomodationType == 0) ? 'BLK': ''}}       
        @{{client.blkNo| uppercase}}, @{{client.address| uppercase}}, @{{ (client.unitNo) ? (client.unitNo| uppercase)+',' : ''}}SINGAPORE @{{client.postalCode| uppercase}}<br/>
        <span ng-if="client.handphone || client.homeTel" > Contact : @{{ (client.handphone) ? (client.handphone): (client.homeTel)}}<br/> </span>
      </strong>

       <br/>
       <div style="min-height: 50px;" class="prelinedata">  @{{caseFile.content}}</div><br/><br/>
       Your Sincerely,<br/>
       <div style="margin-top: 80px;" class="prelinedata">&nbsp;</div>
       @{{approved.authorizedName}}<br/>
       @{{approved.designation}}<br/>
		
     </p>
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

<!-- AngularJS  Scripts -->
<script src="{{ asset("js/angular-spinners.min.js") }}"></script>
<script src="{{ asset("js/app/packages/dirPagination.js") }}"></script>
<script src="{{ asset("js/app/helper.js") }}"></script>
<script src="{{ asset("js/jquery.spellchecker.js") }}" ></script>
<script src="{{ asset("js/app/caseApp.js") }}"></script>
<script src="{{ asset("js/app/controllers/queue.js") }}"></script>
<script src="{{ asset("js/JavaScriptSpellCheck/include.js") }}"   ></script>

<script src="{{ asset("js/angular-sanitize.js") }}" ></script>
<script src="{{ asset("js/es5-shim.js") }}"></script>
<script src="{{ asset("js/select.js") }}" ></script>
<script>
var mpAdmin = "{{ Entrust::hasRole(['mp', 'admin']) }}";
var counterWriter = "{{ Entrust::hasRole(['writer', 'counterA']) }}";
</script>
<script type="text/javascript">
document.createElement('ui-select');
document.createElement('ui-select-match');
document.createElement('ui-select-choices');
// Init the text spellchecker
var spellchecker = new $.SpellChecker('#content', {
  lang: 'en',
  parser: 'text',
  webservice: {
    path: '/webservices/php/SpellChecker.php',
    driver: 'google'
  },
  suggestBox: {
    position: 'below'
  },
  incorrectWords: {
    container: '#incorrect-word-list'
  }
});

// Bind spellchecker handler functions
spellchecker.on('check.success', function() {
  alert('There are no incorrectly spelt words.');
});

// Check the spelling when user clicks on button
$("#check-spelling-button").click(function(e){
  spellchecker.check();
});




</script>
@stop