@extends('layouts.blank')

<!-- Example -->
<link type="text/css" href="{{ asset("css/custom.css") }}" rel="stylesheet" />

@section('main_container')
<div ng-app="application">
  <div ng-controller="reportBController"  data-ng-init="init({{Auth::user()->id}})">
    <div class="right_col" role="main" >
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Report B </h3>
          </div>

        </div>

        <div class="clearfix"></div>

        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
               
                <a ng-show="(download == true)" class="btn btn-info" href="{{ route('pdfviewB') }}"><i class="fa fa-download fa-fw"></i>Download PDF</a>
                <div class="clearfix"></div>            
              </div>
              <div class="x_content"  id="pdf-this">
     
                <h4 style="float:right">MPS Form B</h4>
                <br>
                <h3 style="text-align: center;">MPS Data - Submission Record </h3>              

                <div class="centerText" style="text-align: center;">
                  <div class="form-group">
                    <label for="submitted" class="control-label">By</label>                   
                    <label for="submitted" class="control-label" style=" min-width: 150px; text-align: left;border-bottom: 1px solid #34495e;margin-left: 10px;">@{{report.submitted}}</label>
                    <div>
                      <label class="control-label">(Branch)</label>
                    </div>
                    <br>
                    <label  class="control-label">for</label>                   
                    <label  class="control-label" style=" min-width: 50px; text-align: left;border-bottom: 1px solid #34495e;margin-left: 10px;">@{{report.quarter}}</label>
                    <label  class="control-label">(Quarter)</label>  
                    <label  class="control-label" style=" min-width: 60px; text-align: left;border-bottom: 1px solid #34495e;margin-left: 10px;">@{{report.year}}</label>
                    <label  class="control-label">(Year)</label>
                  </div> 
                  <br>
                  <table class="table report" style="width: 100%;text-align: left;    border: 1px solid black; max-width: 100%;margin-bottom: 20px;">
                    <thead>
                      <tr>
                        <th style="border: 1px solid black;">MONTH
                        </th>
                        <th style="border: 1px solid black;" >No Of Sessions
                        </th>    
                        <th style="border: 1px solid black;" >No Of Cases
                        </th> 
                        <th style="border: 1px solid black;">Remarks
                        </th>               
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat="x in data">
                        <td style="border: 1px solid black;">@{{x.month}}</td>
                        <td style="border: 1px solid black;">@{{x.sessions}}</td>
                        <td style="border: 1px solid black;">@{{x.cases}}</td>
                        <td style="border: 1px solid black;">@{{ x.remarks }}</td>
                      </tr>
                    </tbody>
                  </table>           
                  <div class="row">
                    <div class="col-md-2" style="width: 16.66666667%; display: inline-block;"> </div> 
                    <div class="col-md-2"  style="width: 16.66666667%; display: inline-block;">Submitted By: </div>
                    <div class="col-md-2"  style="width: 16.66666667%; display: inline-block; line-height: 32px;">
                      <hr class="line" style="margin-bottom: -10px !important;">  <label class="subname" style="margin-top: 10px !important;"> Signature</label>
                      <hr class="line" style="margin-bottom: -10px !important;">  <label class="subname"> Name</label>
                      <hr class="line" style="margin-bottom: -10px !important;" >  <label class="subname" > Date</label></div>
                      <div class="col-md-2"  style="width: 16.66666667%; display: inline-block;">Received by: </div>
                      <div class="col-md-2"  style="width: 16.66666667%; display: inline-block;line-height: 32px;"><hr class="line" style="margin-bottom: -10px !important;">  <label class="subname" > Signature</label>
                       <hr class="line" style="margin-bottom: -10px !important;">  <label class="subname" > Name</label>
                       <hr class="line" style="margin-bottom: -10px !important;">  <label class="subname" > Date</label>
                     </div>
                     <div class="col-md-2"  style="width: 16.66666667%"></div>
                   </div>
                 </div>
               </div>
               <!-- end of user-activity-graph -->

             </div>
           </div>
         </div>
       </div>
     </div>

     <!-- Modal (Pop up when detail button clicked) -->
     <div class="modal fade" id="reportModal" data-backdrop="static" data-keyboard="false"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close"  onClick="javascript:window.location.href='/'" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Report B</h4>
          </div>
          <div class="modal-body">
            <form name="formReport" class="form-horizontal" novalidate="">

              <fieldset> 
                <legend> Date   </legend>
                <div class="form-group error">
                  <label for="quarter" class="col-sm-3 control-label">Quarter *</label>
                  <div class="col-sm-9">
                    <select ng-model="report.quarter" class="form-control" id="quarter" name="quarter" ng-required="true">
                      <option ng-repeat="quarter in quarters"  value="@{{quarter}}" >@{{quarter}}</option>
                    </select>

                    <span class="help-inline" 
                    ng-show="formReport.quarter.$touched && formReport.quarter.$invalid ">Quarter is required</span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="year" class="col-sm-3 control-label">Year *</label>
                  <div class="col-sm-9">
                   <select ng-model="report.year" class="form-control"  id="year" name="year" ng-required="true" >
                    <option ng-repeat="year in years" value="@{{year}}" >@{{year}}</option>
                  </select><span class="help-inline" 
                  ng-show="formReport.year.$touched && formReport.year.$invalid ">Year is required</span>
                </div>
              </div>


            </fieldset>
            <legend> Details   </legend>
            <div class="form-group ">
              <label for="submitted" class="col-sm-3 control-label">Submitted By *</label>
              <div class="col-sm-9">
                <input type="text" class="form-control " id="submitted" name="submitted" placeholder="Submitted By" value="@{{submitted}}" 
                ng-model="report.submitted" ng-required="true">
                <span class="help-inline" 
                ng-show="formReport.submitted.$touched && formReport.submitted.$invalid ">Submitted By is required</span>
              </div>
            </div>
            <div class="form-group ">
              <label for="remarks1" class="col-sm-3 control-label">Remarks 1</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="remarks1" name="remarks1" placeholder="Remarks 1" value="@{{remarks1}}" 
                ng-model="report.remarks1">                        
              </div>
            </div>
            <div class="form-group ">
              <label for="remarks2" class="col-sm-3 control-label">Remarks 2</label>
              <div class="col-sm-9">
                <input type="text" class="form-control " id="remarks2" name="remarks2" placeholder="Remarks 2" value="@{{remarks2}}" 
                ng-model="report.remarks2">                        
              </div>
            </div>  
            <div class="form-group ">
              <label for="remarks3" class="col-sm-3 control-label">Remarks 3</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="remarks3" name="remarks3" placeholder="Remarks 3" value="@{{remarks3}}" 
                ng-model="report.remarks3">                        
              </div>
            </div>
            <div class="form-group ">
              <label for="remarks4" class="col-sm-3 control-label">Remarks 4</label>
              <div class="col-sm-9">
                <input type="text" class="form-control " id="remarks4" name="remarks4" placeholder="Remarks 4" value="@{{remarks4}}" 
                ng-model="report.remarks4">                        
              </div>
            </div>


          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btn-save" ng-click="getData()" ng-disabled="formReport.$invalid">OK</button>
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
@endsection

@section('scripts')

@parent
<script src="{{ asset("js/angular.min.js") }}"></script> 
<script src="{{ asset("js/angular-route.min.js") }}"></script>
<!-- load angular -->

<!-- AngularJS  Scripts -->
<script src="{{ asset("js/app/app.js") }}"></script>
<script src="{{ asset("js/app/packages/dirPagination.js") }}"></script>
<script src="{{ asset("js/app/helper.js") }}"></script>

<script src="{{ asset("js/app/controllers/reportB.js") }}"></script>

@stop