@extends('layouts.blank')

@push('stylesheets') 
<!-- Example -->
<link href="{{ asset("css/custom.css") }}" rel="stylesheet">

@endpush

@section('main_container')
<div ng-app="application">
  <div ng-controller="reportAController"  data-ng-init="init({{Auth::user()->id}})">
    <div class="right_col" role="main"  >
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Form A</h3>
            <a ng-show="(download == true)" class="btn btn-info" href="{{ route('pdfviewA') }}"><i class="fa fa-download fa-fw"></i>Download PDF</a>
            <button class="btn btn-info" ng-click="exportToExcel('#pdfelement')">
              <span class="glyphicon glyphicon-share"></span> Export to Excel
            </button>
            <div class="clearfix"></div>
          </div>

        </div>
        
        <div class="clearfix"></div>

        <div class="container table-responsive"  id="pdf-this">



          <div class=" row" >

            <div class="col-md-6" >

             <h5>ANALYSIS OF MEET-THE-PEOPLE SESSION </h5></div>
             <div class="col-md-6" style="    text-align: right;" >
               Date: @{{startDate1 | date:'MM/dd/yyyy'}} To @{{endDate1 | date:'MM/dd/yyyy'}} </div>
             </div>
             <div class="clearfix"></div>
             <div class="row">
              <h2 class="centerText">PEOPLES ACTION PARTY<br/>
                ANALYSIS OF MEET THE PEOPLE SESSION CASES </h2>
              </div> 
              <table  class="table report" id="pdfelement" style="margin-bottom: 50px;">
                <thead>
                  <tr  >
                    <th style="transform: rotate(270deg);    vertical-align: inherit;text-align: left;" > Type of Accomodation</th>
                    <th ng-repeat="x in refs" ng-init="$last && ngRepeatFinished()" style="transform: rotate(270deg);    vertical-align: inherit;text-align: left;">@{{formatHeading(x.description)}}  </th> 
                    <th style="transform: rotate(270deg);    vertical-align: inherit;text-align: left;"  >Total</th>                                
                  </tr>
                </thead>
                <tbody>
                  <tr> <td >HDB</td>
                  </tr>
                  <tr ng-repeat="item in acco1" ng-init="$last && ngRepeatFinished()" >
                    <td >@{{item.title}}</td><td 
                    <td ng-repeat="prop in refs" ng-init="$last && ngRepeatFinished()">@{{item[prop.id]}}</td>
                    <td >@{{item.total}}</td>
                  </tr>
                  <tr> <td >Private</td>
                  </tr>
                  <tr ng-repeat="item in acco2" ng-init="$last && ngRepeatFinished()">
                    <td >@{{item.title}}</td><td 
                    <td ng-repeat="prop in refs" ng-init="$last && ngRepeatFinished()">@{{item[prop.id]}}</td>
                    <td >@{{item.total}}</td>
                  </tr>
                  <tr> <td >Race</td>
                  </tr>
                  <tr ng-repeat="item in racedata" ng-init="$last && ngRepeatFinished()">
                    <td >@{{item.title}}</td><td 
                    <td ng-repeat="prop in refs" ng-init="$last && ngRepeatFinished()">@{{item[prop.id]}}</td>
                    <td >@{{item.total}}</td>
                  </tr>
                  <tr> <td >Age</td>
                  </tr>
                  <tr ng-repeat="item in agedata"   ng-init="$last && ngRepeatFinished()">
                    <td >@{{item.title}}</td><td 
                    <td ng-repeat="prop in refs" ng-init="$last && ngRepeatFinished()">@{{item[prop.id]}}</td>
                    <td >@{{item.total}}</td>
                  </tr>
                  <tr class="last">
                    <td >Total</td><td 
                    <td ng-repeat="prop in refs" ng-init="$last && ngRepeatFinished()"></td>
                    <td >@{{item.total}}</td>
                  </tr> 
                </tbody>
              </table>           
              <div class="row"     style="margin-bottom: 30px;">


                <div class="col-md-8" style="width: 60%;
                vertical-align: top;
                display: inline-block;">
                <div class="pull-left" style="text-align: left;float:left;" >
                  NOTE: Each case means each contact or appearance at the Meet-the-People Session</div>
                  <br><br>
                  <label class="pull-left" ><strong> Remarks :</strong></label>
                  <br><br>
                  <div class="pull-left" > @{{report.remarks}}</div>
                </div>
                <div class="col-md-4 pull-left" style="width:35%; float:right;
                display: inline-block;">
                <div class = "row">
                 <div  style="width: 50%;"> <label class="pull-left" style="float: left; " >Compiled by :</label> </div>
                 <div class = "col-md-6" style="width: 50%;float: right;"><div class="linediv"    style="border-bottom: 1px solid #34495e; height: 20px; margin-bottom: 5px;"> @{{report.compiled}}  </div></div>
               </div>
               <br>
               <div class = "row">
                 <div style="width: 50%;"> <label class="pull-left" style="float: left;"> Designation :</label> </div>
                 <div class = "col-md-6" style="width: 50%;float: right;   "><div class="linediv" style=" border-bottom: 1px solid #34495e; height: 20px; margin-bottom: 5px;"> @{{report.designation}}</div>
               </div>
             </div>
             <br>
             <div class = "row">
               <div style="width: 50%;"> <label class="pull-left" style="float: left;    margin-bottom: 5px;" >Contact :</label> </div>
               <div class = "col-md-6" style="width: 50%;float: right; "><div class="linediv" style="border-bottom: 1px solid #34495e; height: 20px; margin-bottom: 5px;"> @{{report.contact}}  </div>
             </div>
           </div>
           <br>
           <div class = "row">
             <div style="width: 50%;"> <label class="pull-left" style="float: left;    margin-bottom: 5px;"> Date :</label> </div>
             <div class = "col-md-6" style="width: 50%;float: right;  ">@{{dateVal | date:'MM/dd/yyyy'}}  <div class="linediv" style=" border-bottom: 1px solid #34495e; height: 20px;  margin-bottom: 5px;    margin-top: -10px;"></div>
           </div>
         </div>

       </div>

     </div>

     <!-- end of user-activity-graph -->

   </div>


 </div>
</div>

<!-- Modal (Pop up when detail button clicked) -->
<div class="modal fade" id="reportModal" data-backdrop="static" data-keyboard="false"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  onClick="javascript:window.location.href='/'" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">Report A</h4>
      </div>
      <div class="modal-body">
        <form name="formReport" class="form-horizontal" novalidate="">

          <fieldset> 
            <legend> Date   </legend>
            <div class="form-group ">
              <label class="col-sm-2 control-label">Start Date</label><div class="col-sm-4"><input   type="date" id="startDate" class="form-control" ng-model="startDate" value="@{{startDate1 | date:MM/dd/yyyy}}" max="@{{today | date:'yyyy-MM-dd'}}" ></div>
              <label class="col-sm-2 control-label">End Date</label><div class="col-sm-4"><input type="date" id="endDate" class="form-control" ng-model="endDate" max="@{{today | date:'yyyy-MM-dd'}}" ng-change='checkDateRange(startDate,endDate)'> </div>
            </div>
          </fieldset>

          <legend> Details   </legend>
          <div class="form-group ">
            <label for="compiled" class="col-sm-3 control-label">Complied By </label>
            <div class="col-sm-9">
              <input type="text" class="form-control " id="compiled" name="compiled" placeholder="Compiled By" value="@{{compiled}}" 
              ng-model="report.compiled" >

            </div>
          </div>
          <div class="form-group ">
            <label for="designation" class="col-sm-3 control-label">Designation</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" value="@{{designation}}" 
              ng-model="report.designation">                        
            </div>
          </div>
          <div class="form-group ">
            <label for="contact" class="col-sm-3 control-label">Contact</label>
            <div class="col-sm-9">
              <input type="text" class="form-control " id="contact" name="contact" placeholder="Contact " value="@{{contact}}" 
              ng-model="report.contact">                        
            </div>
          </div>  
          <div class="form-group ">
            <label for="remarks" class="col-sm-3 control-label">Remarks </label>
            <div class="col-sm-9">
              <textarea type="text" class="form-control" id="remarks" name="remarks" placeholder="remarks " value="@{{remarks}}" 
              ng-model="report.remarks"> </textarea>                       
            </div>
          </div>
          


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="getData()" >OK</button>
        <button type="button" class="btn btn-default" id="btn-save" onClick="javascript:window.location.href='/'" >Cancel</button>
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

<div id="editor"></div>
@endsection

@section('scripts')

@parent
<script src="{{ asset("js/angular.min.js") }}"></script> 
<script src="{{ asset("js/angular-route.min.js") }}"></script>
<!-- load angular -->
<!-- AngularJS  Scripts -->

<script src="{{ asset("js/app/controllers/reportA.js") }}"></script>

@stop