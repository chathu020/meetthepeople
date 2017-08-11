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
      <h3>Recipient <small>Management</small></h3>
      <hr> 
    </div>
  </div>
  <div class="clearfix"></div>

  <div  ng-controller="recipientsController">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 pull-left">
          <button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)"><i class="fa fa-plus fa-fw"></i>Add New Recipient</button>
        </div>
        <div class="col-xs-6">
         <div class="box-tools pull-right" style="display:inline-table">        
          <div class="input-group">
            <input type="text" class="form-control input-sm ng-valid ng-dirty" placeholder="Search" ng-model="searchText" name="table_search" title="" tooltip="" data-original-title="Min character length is 3">
            <span class="input-group-addon"><i class="fa fa-search fa-fw"></i>Search</span>
          </div>                
        </div>
      </div>
    </div>
    <div class="row">
     <div class="col-md-12 table-responsive">
       <!-- Table-to-load-the-data Part -->
       <table class="table">
        <thead>
          <tr>
            <th ng-click="sort('organization')">Organization
              <span class="glyphicon sort-icon" ng-show="sortBy=='organization'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
              <th ng-click="sort('address')">Organization Address
                <span class="glyphicon sort-icon" ng-show="sortBy=='address'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>    
                <th ng-click="sort('attention')">Attention
                 <span class="glyphicon sort-icon" ng-show="sortBy=='attention'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>   
                 <th>Actions</th>         
               </tr>
             </thead>
             <tbody>
              <tr dir-paginate="recipient in recipients | filter: searchText| orderBy:sortBy:reverse| itemsPerPage: pageSize"  current-page="currentPage">
                <td>@{{ recipient.organization }}</td>
                <td>@{{ recipient.address | limitTo: 50 }} @{{recipient.content.length  > 50 ? '......' : ''}}</td>
                <td>@{{ recipient.attention }}</td>
                <td>
                  <button class="btn btn-primary btn-xs btn-detail" ng-click="toggle('edit', recipient.id)"><i class="fa fa-pencil fa-fw"></i>Edit</button>
                  <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(recipient.id)"><i class="fa fa-trash fa-fw"></i>Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
          <dir-pagination-controls class="pull-right" on-page-change="pageChanged(newPageNumber)" recipient-url="recipients/dirPagination.html" ></dir-pagination-controls>

          <!-- End of Table-to-load-the-data Part -->
          <!-- Modal (Pop up when detail button clicked) -->
          <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <h4 class="modal-title" id="myModalLabel">@{{form_title}}</h4>
                </div>
                <div class="modal-body">
                  <form name="formRecipient" class="form-horizontal" novalidate="">                 
                    <div class="form-group error">
                      <label for="organization" class="col-sm-3 control-label">Organization *</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="organization" name="organization" placeholder="Organization" value="@{{organization}}" 
                        ng-model="recipient.organization" ng-required="true" organization-verify>
                        <span class="help-inline" 
                        ng-show="formRecipient.organization.$touched && formRecipient.organization.$invalid && formRecipient.organization.$error.organizationVerify ">Organization already exists</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="address" class="col-sm-3 control-label">Address *</label>
                      <div class="col-sm-9">
                        <textarea rows="4" class="form-control" id="address" name="address" placeholder="Address" value="@{{address}}" 
                        ng-model="recipient.address" ng-required="true" ></textarea>

                        <span class="help-inline" 
                        ng-show="formRecipient.address.$touched && formRecipient.address.$invalid">Address is required</span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="attention" class="col-sm-3 control-label">Attention *</label>
                      <div class="col-sm-9">
                        <input  class="form-control" id="attention" name="attention" placeholder="Attention" value="@{{attention}}" 
                        ng-model="recipient.attention" ng-required="true" >

                        <span class="help-inline" 
                        ng-show="formRecipient.attention.$touched && formRecipient.attention.$invalid">Attention is required</span>
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="email" class="col-sm-3 control-label">Email</label>
                      <div class="col-sm-9">
                        <input  class="form-control" type="email" id="email" name="email" placeholder="Email Address" value="@{{email}}" 
                        ng-model="recipient.email" >

                        <span class="help-inline" 
                        ng-show="formRecipient.email.$touched && formRecipient.email.$invalid">Email Address is not valid</span>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="formRecipient.$invalid"><i class="fa fa-save fa-fw"></i>Save changes</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                </div>
              </div>
            </div>
          </div>
        </div>
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

<script src="{{ asset("js/app/controllers/recipient.js") }}"></script>
@stop