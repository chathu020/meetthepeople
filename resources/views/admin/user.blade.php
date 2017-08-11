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
      <h3>Users <small>Management</small></h3>
      <hr> 
  </div>
</div>
<div class="clearfix"></div>

<div  ng-controller="usersController">
    <div class="container">
        <div class="row">
            <div class="col-xs-3 pull-left">
                <button id="btn-add" class="btn btn-primary btn-xs" ng-click="toggle('add', 0)"><i class="fa fa-plus fa-fw"></i>Add New user</button>
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
 <div class="col-md-12 table-responsive">
<!-- Table-to-load-the-data Part -->
<table class="table">
    <thead>
        <tr>
            <th ng-click="sort('id')">ID
                <span class="glyphicon sort-icon" ng-show="sortBy=='id'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th>
            <th ng-click="sort('name')">Name
                <span class="glyphicon sort-icon" ng-show="sortBy=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th>
            <th ng-click="sort('email')">Email
                <span class="glyphicon sort-icon" ng-show="sortBy=='email'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th>
            <th ng-click="sort('phonenumber')">Contact No
                <span class="glyphicon sort-icon" ng-show="sortBy=='phonenumber'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
            </th>
            <th > Position</th>
            <th >Action</th>
        </tr>
    </thead>
    <tbody>
        <tr dir-paginate="user in users | filter: searchText| orderBy:sortBy:reverse| itemsPerPage: pageSize" current-page="currentPage">
            <td>@{{  user.id }}</td>
            <td>@{{ user.name }}</td>
            <td>@{{ user.email }}</td>
            <td>@{{ user.phonenumber }}</td>
            <td>           
                <label class="label label-success" ng-repeat="role in user.roles">@{{ role.display_name }}</label>

            </td>
            <td>
                <button class="btn btn-primary btn-xs btn-detail" ng-click="toggle('edit', user.id)"><i class="fa fa-pencil fa-fw"></i>Edit</button>
                <button class="btn btn-danger btn-xs btn-delete" ng-click="confirmDelete(user.id)"><i class="fa fa-trash fa-fw"></i>Delete</button>
            </td>
        </tr>
    </tbody>
</table>

<dir-pagination-controls class="pull-right" on-page-change="pageChanged(newPageNumber)"  template-url="templates/dirPagination.html" ></dir-pagination-controls>

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
                <form name="formUser" class="form-horizontal" novalidate="">
                 <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Username *</label>
                    <div class="col-sm-9">
                        <input type="username" class="form-control" id="username" name="username" placeholder="Username" value="@{{username}}" 
                        ng-model="user.username" ng-required="true" username-verify ng-disabled="editing">

                        <span class="help-inline" 
                        ng-show="formUser.username.$error.usernameVerify && formUser.username.$touched">Username already exists</span>
                    </div>
                </div>

                <div class="form-group error">
                    <label for="inputEmail3" class="col-sm-3 control-label">Name *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control has-error" id="name" name="name" placeholder="Fullname" value="@{{name}}" 
                        ng-model="user.name" ng-required="true">
                        <span class="help-inline" 
                        ng-show="formUser.name.$touched && formUser.name.$invalid ">Name field is required</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Email *</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="@{{email}}" 
                        ng-model="user.email" ng-required="true">
                        <span class="help-inline" 
                        ng-show="formUser.email.$invalid && formUser.email.$touched ">Valid Email field is required</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password"  class="form-control" id="password" 
                        name="userpassword" placeholder="Password" value="@{{password}}" 
                        ng-model="user.password" ng-required="isRequiredPassword" password-strength="user.password" >
                        <span class="help-inline"  
                        ng-show="formUser.userpassword.$invalid && formUser.userpassword.$touched">Please enter minimum 6 characters</span>
                        <span class="help-inline" data-ng-show='formUser.userpassword.$valid && formUser.userpassword.$dirty && formUser.userpassword.$touched' data-ng-class="strength">This password is @{{strength}} ! </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="passwordconfirm" class="col-sm-3 control-label">Password Confirmation</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="passwordconfirm" name="passwordconfirm" placeholder="Password Confirmation" value="@{{passwordconfirm}}" data-password-verify="user.password"
                        ng-model="user.passwordconfirm" ng-required="isRequiredPassword">
                        <span class="help-inline" 
                        ng-show="formUser.passwordconfirm.$invalid && formUser.passwordconfirm.$touched && formUser.passwordconfirm.$error.passwordVerify">Password does not match</span>
                    </div>
                </div>


                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Contact Number</label>
                    <div class="col-sm-9">
                        <input type="text" only-digits class="form-control no-spinners" id="phonenumber" name="phonenumber" placeholder="Contact Number" value="@{{phonenumber}}" 
                        ng-model="user.phonenumber" >
                        <span class="help-inline" 
                        ng-show="formUser.phonenumber.$invalid && formUser.phonenumber.$touched">Contact number field is required</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Position</label>
                    <div class="col-sm-9">
                        <select name="role" id="role" class="form-control" ng-model="user.roles" ng-options="x as x.display_name for x in roles track by x.id" ng-value="option.id" multiple>

                          @{{selected}}
                      </select>
                      <span class="help-inline" 
                      ng-show="formUser.position.$invalid && formUser.position.$touched">Position field is required</span>
                  </div>
              </div>

          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="formUser.$invalid"><i class="fa fa-save fa-fw"></i>Save changes</button>
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

<script src="{{ asset("js/app/controllers/users.js") }}"></script>
@stop