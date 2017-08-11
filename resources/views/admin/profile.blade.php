@extends('layouts.blank')

@push('stylesheets') 
<!-- Example -->
<link href="{{ asset("css/custom.css") }}" rel="stylesheet">
@endpush

@section('main_container')
   <div ng-app="application">
              <div ng-controller="homeController"  data-ng-init="init({{Auth::user()->id}})">
<div class="right_col" role="main" >
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>User Profile</h3>
              </div>

            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>My Profile <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img class="img-responsive avatar-view" src="{{ Gravatar::src(Auth::user()->email) }}" alt="Avatar" title="Change the avatar">
                        </div>
                      </div>
                      <h3>@{{ user.name }}</h3>

                      <ul class="list-unstyled user_data">
                        <li><i class="fa  fa-phone user-profile-icon"></i> @{{ user.phonenumber }}
                        </li>

                        <li>
                          <i class="fa fa-envelope-square user-profile-icon"></i> {{ Auth::user()->email }}
                        </li>
                       
                      </ul>

                      <button  ng-click="edit({{ Auth::user()->id }})" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</button>
                      <br>                     

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                  </div></div>
                      <!-- end of user-activity-graph -->

                    </div>
                  </div>
                </div>
              </div>
            </div>
         
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
                        <input type="number" only-digits class="form-control no-spinners" id="phonenumber" name="phonenumber" placeholder="Contact Number" value="@{{phonenumber}}" 
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
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save( id)" ng-disabled="formUser.$invalid"><i class="fa fa-save fa-fw"></i>Save changes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
    </div>
</div>
</div>
</div>
</div>
</div>
        <!-- footer content -->
<footer>
  <div class="pull-right">

  </div>
  <div class="clearfix"></div>
</footer>
<!-- /footer content -->
@endsection

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

<script src="{{ asset("js/app/controllers/home.js") }}"></script>
@stop