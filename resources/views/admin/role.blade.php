@extends('layouts.blank')
@section('styles')
@parent

<link href="{{ asset("css/custom.css") }}" rel="stylesheet">
@stop

@section('main_container')

<div class="right_col" role="main" style="min-height: 4140px;" ng-app="application">

  <div class="page-title">
    <div class="title_left">
      <h3>roles <small>Management</small></h3>
      <hr> 
  </div>
</div>
<div class="clearfix"></div>

<div  ng-controller="rolesController">
<div class="table-responsive">
    <!-- Table-to-load-the-data Part -->
    <table class="table">
        <thead>
            <tr>           
                <th ng-click="sort('name')">Name
                <span class="glyphicon sort-icon" ng-show="sortBy=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                <th ng-click="sort('display_name')">Display Name
                <span class="glyphicon sort-icon" ng-show="sortBy=='display_name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
                <th ng-click="sort('description')">Description
                <span class="glyphicon sort-icon" ng-show="sortBy=='description'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>  
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat="role in roles">               
                <td>@{{ role.name }}</td>
                <td>@{{ role.display_name }}</td>
                <td>@{{ role.description }}</td>   

            </tr>
        </tbody>
    </table>
</div>
</div>
</div>

@stop


@section('scripts')
@parent
<script src="{{ asset("js/angular.min.js") }}"></script> 
<!-- load angular -->
<script src="{{ asset("js/angular-spinners.min.js") }}"></script>
<!-- AngularJS  Scripts -->
<script src="{{ asset("js/app/app.js") }}"></script>
<script src="{{ asset("js/app/packages/dirPagination.js") }}"></script>
<script src="{{ asset("js/app/controllers/roles.js") }}"></script>
@stop