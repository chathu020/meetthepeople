<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Meet The People!  </title>
  @section('styles')
  <!-- Bootstrap -->
  <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset("css/font-awesome.min.css") }}" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="{{ asset("css/gentelella.min.css") }}" rel="stylesheet">
  <script src="{{ asset("js/jquery.min.js") }}"></script>
  <link href="{{ asset("css/custom.css") }}" rel="stylesheet">
  <style type="text/css">
  body{
    background: #fdfbfb !important;
    }</style>

  </head>

  <body>
    <div class="right_col maindisplay" role="main"  ng-app="application">
      <div class="container">
        <div class="row display-header centerText">
          <div class="display-logo">
            <img src="{{ asset("images/PAP.png") }}"/>
          </div><h1 class="toptitle">Welcome to Meet the People Session @Whampoa</h1></div>
        <div  ng-controller="displayController" style="min-height:500px">         
          <div class="bigtitle" >  Now Calling
           <div class="row">
            <div class="col-md-6">
             <div class="writer" >   QUEUE NO</div>             
           </div>           
           <div class="col-md-6"> 
            <div class="writer" >COUNTER </div> 
         </div>   
       </div>
       <div class="row listItem" ng-repeat="x in currentMP track by x.created_at">
        <div class="col-md-6">
          <div   class="displayno" style="color: #ef9231;" > @{{x.queueNo| numberformat}}  <div ng-show="!x.queueNo"> !!!</div> 
        </div>        
      </div>
      <div class="col-md-6">
        <div  style="color: #ef9231;" class="displayno" >@{{x.name| uppercase}}  <div ng-show="!x.name"> !!!</div>  </div>
      </div>
    </div>

    <div class="row listItem" ng-repeat="x in current track by x.created_at">
      <div class="col-md-6">
        <div   class="displayno"  > @{{x.queueNo| numberformat}} <div ng-show="!x.queueNo"> !!!</div> </div>
        </div>
      <div class="col-md-6">
        <div   class="displayno" >@{{x.name| uppercase}}  <div ng-show="!x.name"> !!!</div>  </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="sub" >Numbers Missed 
     <table >
      <tr >
        <td class="pendingno" ng-repeat="x in numbers">@{{ x}}</td>   
      </tr>
    </table>
    <div class="clearfix"></div>

  </div>

</div>
<br>
<br>
<br>
<br>

</div>
<div class="centerText lasttitle">The number called may not be in sequence</div>
</div>
</div>

<script src="{{ asset("js/bootstrap.min.js") }}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset("js/gentelella.min.js") }}"></script>
<script src="{{ asset("js/helper.js") }}"></script> 
<script src="{{ asset("js/angular.min.js") }}"></script> 
<script src="{{ asset("js/angular-route.min.js") }}"></script>
<!-- load angular -->
<script src="{{ asset("js/angular-spinners.min.js") }}"></script>
<!-- AngularJS  Scripts -->
<script src="{{ asset("js/angular-animate.js") }}"></script>
   
<script src="{{ asset("js/app/controllers/display.js") }}"></script>
</body>
</html>