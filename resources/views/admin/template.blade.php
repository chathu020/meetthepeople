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
      <h3>Template <small>Management</small></h3>
      <hr> 
    </div>
  </div>
  <div class="clearfix"></div>

  <div  ng-controller="templatesController">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 pull-left">
          <button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)"><i class="fa fa-plus fa-fw"></i>Add New Template</button>
        </div>
        <div class="col-xs-6">
         <div class="box-tools pull-right" style="display:inline-table">        
          <div class="input-group">
            <input type="text" class="form-control input-sm ng-valid ng-dirty" placeholder="Search" ng-model="searchText"  name="table_search" title="" tooltip="" data-original-title="Min character length is 3">
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
        <th ng-click="sort('subject')">Subject
          <span class="glyphicon sort-icon" ng-show="sortBy=='subject'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
          <th ng-click="sort('content')">Content
            <span class="glyphicon sort-icon" ng-show="sortBy=='content'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>    
            <th >Actions</th>         
          </tr>
        </thead>
        <tbody>
          <tr dir-paginate="template in templates | filter: searchText| orderBy:sortBy:reverse | itemsPerPage: pageSize"  current-page="currentPage">
            <td>@{{  template.subject }}</td>
            <td>@{{ template.content | limitTo: 50 }} @{{template.content.length  > 50 ? '......' : ''}}</td>
            <td>
              <button class="btn btn-primary btn-xs btn-detail" ng-click="toggle('edit', template.id)"><i class="fa fa-pencil fa-fw"></i>Edit</button>
              <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(template.id)"><i class="fa fa-trash fa-fw"></i>Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <dir-pagination-controls class="pull-right" on-page-change="pageChanged(newPageNumber)" template-url="templates/dirPagination.html" ></dir-pagination-controls>

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
              <form name="formTemplate" class="form-horizontal" novalidate="">                 
                <div class="form-group error">
                  <label for="inputEmail3" class="col-sm-3 control-label">Subject *</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" value="@{{subject}}" 
                    ng-model="template.subject" ng-required="true" subject-verify>
                    <span class="help-inline" 
                    ng-show="formTemplate.subject.$touched && formTemplate.subject.$invalid && formTemplate.subject.$error.subjectVerify ">Subject already exists</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Content *</label>
                  <div class="col-sm-9">
                    <textarea rows="20" class="form-control" id="content" name="content" placeholder="Content" value="@{{content}}" 
                    ng-model="template.content" ng-required="true" ></textarea>

                    <span class="help-inline" 
                    ng-show="formTemplate.content.$touched && formTemplate.content.$invalid">Content is required</span>
                  </div>
                </div>

              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="formTemplate.$invalid"><i class="fa fa-save fa-fw"></i>Save changes</button>
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

  <script src="{{ asset("js/app/controllers/template.js") }}"></script>
  @stop