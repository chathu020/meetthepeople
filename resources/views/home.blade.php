@extends('layouts.blank')

@push('stylesheets') 
<!-- Example -->
<link href="{{ asset("css/custom.css") }}" rel="stylesheet">
@endpush

@section('main_container')


<!-- page content -->
<div class="right_col" role="main">
  <div class="container" >
    <div class="row centerText">
      <div class="animated flipInY col-md-12">
       <a class="btn btn-lg btn-success front-btn" href="/register" >
        <i class="fa fa-users fa-5x front-icon"></i>
        <br>
        Resident Registration</a>
      </div>             
    </div>
    <div class="clearfix"></div>
    <br>


    <div class="row">
     <div class="animated flipInY col-md-6 pull-right">
       <a class="btn btn-lg btn-success front-btn" href="/counterqueue" >
        <i class="fa fa-envelope fa-5x front-icon"></i>
        <br>
        Counter A Queue</a>
      </div>  
      <div class="animated flipInY col-md-6" style="    text-align: right;" >
       <a class="btn btn-lg btn-success front-btn" href="/writerqueue" >
        <i class="fa fa-list-alt fa-5x front-icon"></i>
        <br>
        Writer Queue</a>      
      </div>
    </div>
    <div class="clearfix"></div>
    <br>

    <div class="clearfix"></div>
    <div class="row centerText" >
      <a class="btn btn-lg btn-success front-btn" href="/mpqueue" >
        <i class="fa fa-user fa-5x front-icon"></i>
        <br>
        MP Queue<br/> </a>
      <br/> <strong>Tonight's MP: <label  id="defaultApprovalParty"></label> </strong>
          </select>
      </div>

    </div>
  </div>
  <!-- /page content -->

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
<script type="text/javascript">
$( document ).ready(function() {
   $.ajax({
    url: "/defaultapprovalparty",   
    success: function(data){     
      if(data && data.authorizedName){      
        $("#defaultApprovalParty").html(data.authorizedName);
      }
    }
});
});

</script> 
@stop
