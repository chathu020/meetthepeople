@extends('layouts.blank')
@section('styles')
@parent
<!-- Example -->
<link href="{{ asset("css/custom.css") }}" rel="stylesheet">
@stop

@section('main_container')

<div class="right_col" role="main" style="min-height: 4140px;" ng-app="application">

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
            <div class="col-xs-3 pull-left">
                <button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)"><i class="fa fa-user-plus fa-fw"></i>Add New client</button>
                <button id="btn-add" class="btn btn-primary btn-xs" ng-click="refresh()"><i class="fa fa-refresh fa-fw"></i>Refresh</button>
            </div>
            <div class="col-xs-9">
             <div class="box-tools pull-right" style="display:inline-table">        
              <div class="form-inline" style="display: inline-table">
                  <input type="text" class="form-control input-sm ng-valid ng-dirty" placeholder="Search" ng-model="searchText" name="table_search" title="" tooltip="" data-original-title="Min character length is 3">
                  <span class="input-group-addon"><i class="fa fa-search fa-fw"></i>Search</span>
              </div>
             {{--  <div class="form-inline" style="display: inline-table; padding-left:5%">

                <label  for="pageSize">items per page: </label>
                <input class="form-control" type="number" min="1" max="1000"  ng-model="pageSize" >  
            </div>    --}}             
        </div>
    </div>
</div>
<div class="row">
 <div class="col-md-12 table-responsive customtable">
<!-- Table-to-load-the-data Part -->
<div class="row"> <div class="loading"><spinner show="loading" name="mySpinner" img-src='{{ asset("images/gear.gif") }}' ></spinner></div></div>
<table class="table">
    <thead>
        <tr>
            <th ng-click="sort('nric')">NRIC
                <span class="glyphicon sort-icon" ng-show="sortBy=='nric'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th>
            <th ng-click="sort('name')">Name
                <span class="glyphicon sort-icon" ng-show="sortBy=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th>   
            
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr dir-paginate="client in clients | filter: searchText| orderBy:sortBy:reverse| itemsPerPage: pageSize" current-page="currentPage">
            <td>@{{ client.nric }}</td>
            <td>@{{ client.name }}</td>  
            <td>
              <select ng-model="casereference" ng-options="case.id as case.description for case in caseReferences">                          
              </select>
                <button class="btn btn-default btn-xs btn-basic" ng-click="addQueue(client.nric,casereference)"><i class="fa fa-wrench fa-fw"></i>Add Queue</button>
              </td>   
              <td>
                <button class="btn btn-default btn-xs btn-info" ng-click="caseFiles(client.id)"><i class="fa fa-list fa-fw"></i>Case Files</button>
              </td>       
            <td>
                <button class="btn btn-default btn-xs btn-primary" ng-click="toggle('edit', client.id)"><i class="fa fa-pencil fa-fw"></i>Edit</button>
                 @role(([ 'admin', 'mp']))                  
                <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(client.id)"><i class="fa fa-trash-o fa-lg"></i>Delete</button>
                @endrole
            </td>
        </tr>
    </tbody>
</table>

<dir-pagination-controls class="pull-right"  on-page-change="pageChanged(newPageNumber)" template-url="/templates/dirPagination.html" ></dir-pagination-controls>

<!-- End of Table-to-load-the-data Part -->
<!-- Modal (Pop up when detail button clicked) -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">@{{form_title}}</h4>
            </div>
            <div class="modal-body">
                <form name="formClient" class="form-horizontal" novalidate="">
                 <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Clientname *</label>
                    <div class="col-sm-9">
                        <input type="clientname" class="form-control" id="clientname" name="clientname" placeholder="Clientname" value="@{{clientname}}" 
                        ng-model="client.clientname" ng-required="true" clientname-verify ng-disabled="editing">

                        <span class="help-inline" 
                        ng-show="formClient.clientname.$error.clientnameVerify && formClient.clientname.$touched">Clientname already exists</span>
                    </div>
                </div>

                <div class="form-group error">
                    <label for="inputEmail3" class="col-sm-3 control-label">Name *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control has-error" id="name" name="name" placeholder="Fullname" value="@{{name}}" 
                        ng-model="client.name" ng-required="true">
                        <span class="help-inline" 
                        ng-show="formClient.name.$touched && formClient.name.$invalid ">Name field is required</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Email *</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="@{{email}}" 
                        ng-model="client.email" ng-required="true">
                        <span class="help-inline" 
                        ng-show="formClient.email.$invalid && formClient.email.$touched ">Valid Email field is required</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Contact Number</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control no-spinners" id="phonenumber" name="phonenumber" placeholder="Contact Number" value="@{{phonenumber}}" 
                        ng-model="client.phonenumber" >
                        <span class="help-inline" 
                        ng-show="formClient.phonenumber.$invalid && formClient.phonenumber.$touched">Contact number field is required</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Position</label>
                    <div class="col-sm-9">
                        <select name="role" id="role" class="form-control" ng-model="client.roles" ng-options="x as x.display_name for x in roles track by x.id" ng-value="option.id" multiple>

                          @{{selected}}
                      </select>
                      <span class="help-inline" 
                      ng-show="formClient.position.$invalid && formClient.position.$touched">Position field is required</span>
                  </div>
              </div>

          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="formClient.$invalid">Save changes</button>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
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
@stop


@section('scripts')
@parent
<script src="{{ asset("js/angular.min.js") }}"></script> 
<script src="{{ asset("js/angular-route.min.js") }}"></script>
<!-- load angular -->
<script src="{{ asset("js/angular-spinners.min.js") }}"></script>
<!-- AngularJS  Scripts -->
<script src="{{ asset("js/app/app.js") }}"></script>
<script src="{{ asset("js/app/packages/dirPagination.js") }}"></script>
<script src="{{ asset("js/app/helper.js") }}"></script>
<script src="{{ asset("js/app/controllers/client.js") }}"></script>
@stop