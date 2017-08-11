@extends('layouts.blank')
@section('styles')
@parent
<link href="{{ asset("css/custom.css") }}" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>

@stop
@section('main_container')
<meta name="_token" content="{!! csrf_token() !!}"/>
<div class="right_col" role="main" style="min-height: 4140px;" ng-app="application" >

  <div class="page-title">
    <div class="title_left">
      <h3>Clients <small>Management</small></h3>
      <hr> 
  </div>
</div>

<div class="clearfix"></div>
<div class="container" ng-controller="clientsController">
    <div class="row">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
           @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

        <div class="well">


            {!! Form::model($client, [
                'method' => 'PATCH',
                'route' => ['clients.update', $client->id], 'id'=> 'clientForm'
                ]) !!}   
                
                <fieldset>
                   <legend>Personal Particulars</legend>
                   <!-- NRIC -->   
                   <div class="form-group row">
                    {!! Form::label('nric', 'NRIC *', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4">
                        @if(isset($client) )
                        {!! Form::text('nric',  null, ['class' => 'form-control' ,'readonly' => 'true']) !!}
                        @else
                        {!! Form::text('nric',  null, ['class' => 'form-control', 'id' => 'nric']) !!}
                        @endif
                    </div>
                    {!! Form::label('race', 'Race', ['class' => 'col-md-2 control-label']) !!}
                    <div class=" col-md-4">    
                        <div class="form-check form-check-inline">                    
                            {!! Form::radio('race', 'C', true, ['id' => 'optionC'], ['class' => 'form-check-input']) !!}
                            {!! Form::label('optionC', 'C',['class' => 'form-check-label']) !!} 
                        </div>
                        <div class="form-check form-check-inline">                    
                            {!! Form::radio('race', 'M', false, ['id' => 'optionM'], ['class' => 'form-check-input']) !!}
                            {!! Form::label('optionM', 'M',['class' => 'form-check-label']) !!}
                        </div>
                        <div class="form-check form-check-inline">                    
                            {!! Form::radio('race', 'I', false, ['id' => 'optionI'], ['class' => 'form-check-input']) !!}
                            {!! Form::label('optionI', 'I',['class' => 'form-check-label']) !!}
                        </div>
                        <div class="form-check form-check-inline">                    
                            {!! Form::radio('race', 'Other', false, ['id' => 'optionOther'], ['class' => 'form-check-input']) !!}
                            {!! Form::label('optionOther', 'Other',['class' => 'form-check-label']) !!}
                        </div>
                    </div>
                </div>

                <!-- Name -->
                <div class="form-group row">
                    {!! Form::label('name', 'Name *', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4">
                        {!! Form::text('name', $value = null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                    </div>
                    {!! Form::label('dateOfBirth', 'Birthday *', ['class' => 'col-md-2 control-label']) !!}
                    <div class="col-md-4">
                        {!! Form::date('dateOfBirth', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group row">
                    {!! Form::label('sex', 'Gender', ['class' => 'col-md-2 control-label']) !!}
                    <div class=" col-md-4">    
                        <div class="form-check form-check-inline">                    
                            {!! Form::radio('sex', 'male', true, ['id' => 'male'], ['class' => 'form-check-input']) !!}
                            {!! Form::label('male', 'Male',['class' => 'form-check-label']) !!} 
                        </div>
                        <div class="form-check form-check-inline">                    
                            {!! Form::radio('sex', 'female', false, ['id' => 'female'], ['class' => 'form-check-input']) !!}
                            {!! Form::label('female', 'Female',['class' => 'form-check-label']) !!}
                        </div>
                    </div>
                    {!! Form::label('color', 'NRIC Type', ['class' => 'col-md-2 control-label']) !!}
                    <div class=" col-md-4">    
                        <div class="form-check form-check-inline">                    
                            {!! Form::radio('color', 'pink', true, ['id' => 'pink'], ['class' => 'form-check-input']) !!}
                            {!! Form::label('pink', 'Pink',['class' => 'form-check-label']) !!} 
                        </div>
                        <div class="form-check form-check-inline">                    
                            {!! Form::radio('color', 'blue', false, ['id' => 'blue'], ['class' => 'form-check-input']) !!}
                            {!! Form::label('blue', 'Blue',['class' => 'form-check-label']) !!}
                        </div>
                    </div>
                </div>

            </fieldset>   

            <fieldset>
                <legend>Address</legend>

                <div class=" col-md-6">  
                    <div class="form-group row">
                        {!! Form::label('blkNo', 'Block No *', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::text('blkNo', $value = null, ['class' => 'form-control', 'placeholder' => 'Block No', 'id' => 'blkNo']) !!}
                        </div>                  
                    </div> 
                    <!-- Address -->
                    <div class="form-group row">
                        {!! Form::label('address', 'Street Name *', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::textarea('address', $value = null, ['class' => 'form-control', 'rows' => 3, 'id' => 'address']) !!}
                        </div>

                    </div>
                    <!-- Unit No -->   
                    <div class="form-group row">
                        {!! Form::label('unitNo', 'Unit No *', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-8">
                            {!! Form::text('unitNo', $value = null, ['class' => 'form-control', 'placeholder' => 'Unit No', 'id' => 'unitNo']) !!}
                        </div>
                    </div>

                    <!-- Postal Code -->   
                    <div class="form-group row">
                        {!! Form::label('postalCode', 'Postal Code *', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-7">
                            {!! Form::text('postalCode', $value = null, ['class' => 'form-control', 'placeholder' => 'Postal Code', 'ng-keyup' => 'validatePostalcode()', 'id' => 'postalCode']) !!}
                        </div>
                        <div class="col-md-1">
                        <div ng-if="zone != null && zone != ''" class="square green">@{{zone}}</div>
                        <div id="postalvalid-box"  class="square blue"></div>
                        </div>
                    </div>
                </div>

                <div class=" col-md-6">
                    <div class="form-group row">
                        {!! Form::label('accomodationType', 'Accommodation', ['class' => 'col-md-4 control-label']) !!}
                        <div class=" col-md-8">    
                            <div class="form-check form-check-inline">                    
                                {!! Form::radio('accomodationType', 'Hdb', true, ['id' => 'optionhdb'], ['class' => 'form-check-input']) !!}
                                {!! Form::label('hdb', 'HDB',['class' => 'form-check-label']) !!} 
                            </div>
                            <div class="form-check form-check-inline">                    
                                {!! Form::radio('accomodationType', 'Private', false, ['id' => 'optionprivate'], ['class' => 'form-check-input']) !!}
                                {!! Form::label('optionprivate', 'Private',['class' => 'form-check-label']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                      {!! Form::label('roomType', 'Type *', ['class' => 'col-md-4 control-label']) !!}
                      <div class=" col-md-8">    
                        <select id="roomType" name="roomType" value="roomType"  class="form-control">
                            <option value="0">Please choose Accomodation Type</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                   {!! Form::label('status', 'Status', ['class' => 'col-md-4 control-label']) !!}
                   <div class="col-md-8">
                    <div class="form-check form-check-inline">                    
                        {!! Form::radio('status', 'own', true, ['id' => 'optionown'], ['class' => 'form-check-input']) !!}
                        {!! Form::label('optionown', 'Own',['class' => 'form-check-label']) !!} 
                    </div>
                    <div class="form-check form-check-inline">                    
                        {!! Form::radio('status', 'rented', false, ['id' => 'private'], ['class' => 'form-check-input']) !!}
                        {!! Form::label('rented', 'Rented',['class' => 'form-check-label']) !!}
                    </div>
                </div>
            </div>

        </div>
    </fieldset>

    <fieldset>

        <legend>Contacts</legend>
        <div class="row">
         <div class="col-md-6"> 
            <!-- No Contacts -->   
            <div class="form-group row">
                {!! Form::label('noContact', 'No Contacts', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-7">       
                    {!! Form::hidden('noContact', false) !!}                  
                    {!! Form::checkbox('noContact',  1, null, ['id' => 'noContactbox','class' => 'form-check-input']) !!}                    
                </div>
                <div class="col-md-1">       
                   <div class="prefer">   Preferred?</div>
               </div>
           </div>

           <!-- handphone -->   
           <div class="form-group row">
            {!! Form::label('handphone', 'Mobile No', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-7">
                {!! Form::number('handphone', $value = null,['id' => 'handphone','class' => 'form-control  no-spinners', 'placeholder' => 'Hand Phone No']) !!}
            </div>
            <div class="col-md-1">       
                {!! Form::hidden('preferred', false) !!}                  
                <input type="checkbox" value="mobile"  id="mobile" name="preferred[]" {{ (in_array('mobile', $client->preferred)) ? 'checked="checked" ' : '' }}>  
            </div>
        </div>

        <!-- officeTel -->   
        <div class="form-group row">
            {!! Form::label('officeTel', 'Office Tel No', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-7">
                {!! Form::number('officeTel', $value = null,['id' => 'officeTel','class' => 'form-control  no-spinners', 'placeholder' => 'Office Tel No']) !!}
            </div>
            <div class="col-md-1"> 
               <input type="checkbox" value="office" id="office" name="preferred[]" {{ (in_array('office', $client->preferred)) ? 'checked="checked" ' : '' }}>   
           </div>
       </div>

       <!-- homeTel -->   
       <div class="form-group row">
        {!! Form::label('homeTel', 'Home Tel No', ['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-7">
            {!! Form::number('homeTel', $value = null,['id' => 'homeTel','class' => 'form-control  no-spinners', 'placeholder' => 'Home Tel No']) !!}
        </div>
        <div class="col-md-1"> 
          <input type="checkbox" value="home"  id="home" name="preferred[]" {{ (in_array('home', $client->preferred)) ? 'checked="checked" ' : '' }}>    
      </div>
  </div>
  <!-- pagerNo -->   
  <div class="form-group row">
    {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">
        {!! Form::text('email', $value = null, ['id' => 'email','class' => 'form-control  no-spinners', 'placeholder' => 'Email Address']) !!}
    </div>
    <div class="col-md-1"> 
        <input type="checkbox" value="email"  id="email" name="preferred[]" {{ (in_array('email', $client->preferred)) ? 'checked="checked" ' : '' }}> 
    </div>
</div>
</div>
<div class="col-md-6"> 
   <!-- No Contacts -->   
   <div class="form-group row">
    {!! Form::label('language', 'Language', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-8">

        {!! Form::hidden('language', false) !!}                  
        <div class="form-check form-check-inline">                    
         <input type="checkbox" value="eng" name="language[]" {{ (in_array('eng', $client->language)) ? 'checked="checked" ' : '' }}>
         {!! Form::label('language', 'Eng',['class' => 'form-check-label']) !!}
     </div>

     <div class="form-check form-check-inline">                    
       <input type="checkbox" value="mand" name="language[]" {{ (in_array('mand', $client->language)) ? 'checked="checked" ' : '' }}>
       {!! Form::label('language', 'Mand',['class' => 'form-check-label']) !!}
   </div>

   <div class="form-check form-check-inline">                    
    <input type="checkbox" value="malay" name="language[]" {{ (in_array('malay', $client->language)) ? 'checked="checked" ' : '' }}>
    {!! Form::label('language', 'Malay',['class' => 'form-check-label']) !!}
</div>


<div class="form-check form-check-inline">                    
    <input type="checkbox" value="tamil" name="language[]" {{ (in_array('tamil', $client->language)) ? 'checked="checked" ' : '' }}>
    {!! Form::label('language', 'Tamil',['class' => 'form-check-label']) !!}
</div>


<div class="form-check form-check-inline">                    
    <input type="checkbox" value="dialet" name="language[]" {{ (in_array('dialet', $client->language)) ? 'checked="checked" ' : '' }}>
    {!! Form::label('language', 'Dialet',['class' => 'form-check-label']) !!}
</div>
</div>
</div>

<div class="form-group row">
    {!! Form::label('notes', 'Notes', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-8">
        {!! Form::textarea('notes', $value = null, ['class' => 'form-control', 'rows' => 3]) !!}
    </div>
</div> 
<div class="form-group row">
    <label for="notes" class="col-md-4 control-label">Information</label>  
     <div class="col-md-8">
    <div class="form-check form-check-inline" >                    
            <input
              type="checkbox"
              name="resident[]"
              value="agency"     {{ (in_array('agency', $client->resident)) ? 'checked="checked" ' : '' }} 
              > Resident consent to release information to relevant agencies
        </div>
        <div class="form-check form-check-inline"  >                    
            <input
              type="checkbox"
              name="resident[]"
              value="whampoa" {{ (in_array('whampoa', $client->resident)) ? 'checked="checked" ' : '' }}
              > Resident consent to receive information from Whampoa PAP
        </div>
          </div>
</div>

<div class="form-group row">
    <div class="col-md-8">
       <select class="form-control" id="referenceSelect">                
    </select>
</div>
<div class="col-md-4">
    <span class="btn btn-primary" ng-click="addtoQueue()"><i class="fa fa-wrench fa-fw"></i>Add Queue</span>
</div>
</div>   
</div>
</div>
</fieldset>
<!-- Submit Button -->
<div class="form-group" >
    <div class="col-md-10 col-md-offset-2">                
        <a href="/clients" class="btn btn-md btn-default  pull-right ">Cancel</a>
        <button class="btn btn-md btn-info pull-right" type="submit" value="Submit"><i class="fa fa-edit fa-fw"></i>Update</button>
         @role(([ 'admin', 'mp']))
        <button class="btn btn-danger  pull-right" ng-click="deleteClient()"><i class="fa fa-trash fa-fw"></i>Delete</button>
        @endrole
        </div>
    </div>
</div>

</fieldset>

{!! Form::close()  !!}

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
<script>
var roomType = "{{ $client->roomType }}";
if(!roomType || roomType == "")
    roomType =null;
var accommodation = "{{ $client->accomodationType }}";
var noContact = "{{ $client->noContact }}";
var nric= "{{ $client->nric }}";
var id= "{{ $client->id }}";
</script>
<script src="{{ asset("js/helper.js") }}"></script>
<script src="{{ asset("js/angular.min.js") }}"></script> 
<script src="{{ asset("js/angular-route.min.js") }}"></script>
<!-- load angular -->
<script src="{{ asset("js/angular-spinners.min.js") }}"></script>
<!-- AngularJS  Scripts -->
<script src="{{ asset("js/app/packages/dirPagination.js") }}"></script>
<script src="{{ asset("js/app/helper.js") }}"></script>
<script src="{{ asset("js/app/app.js") }}"></script>
<script src="{{ asset("js/app/controllers/edit.js") }}"></script> 
<script src="{{ asset("js/bootstrapValidator.min.js") }}"></script>

<script  type="text/javascript">
$('#clientForm').on('status.field.bv', function (e, data) {

    var element = data.element;
    $(element).next('.glyphicon').removeClass('glyphicon-ok glyphicon-remove');
    $(element).nextAll('.help-block').html('');
    $(element).parent('.form-group').removeClass('has-success has-error');
    $(element).parent('.form-group').removeClass('has-success');
});

$(document).ready(function() {
    $('#clientForm').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nric: {
                message: 'The NRIC is not valid',
                validators: {
                    notEmpty: {
                        message: 'The NRIC is required and cannot be empty'
                    },
                    stringLength: {
                       // min: 6,
                       // max: 30,
                       // message: 'The NRIC must be more than 6 and less than 30 characters long'
                   }                                 
               }
           },
           name: {
            validators: {
                notEmpty: {
                    message: 'The Name is required and cannot be empty'
                }
            }
        },
        email: {
          validators: {       
            regexp: {
              regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
              message: 'The email address is not valid'
          }
      }
  }, 
  unitNo: {
    validators: {
        notEmpty: {
            message: 'The Name is required and cannot be empty'
        }
    }
}, 
postalCode: {
    validators: {
        notEmpty: {
            message: 'The Name is required and cannot be empty'
        }
    }
}, 
address: {
    validators: {
        notEmpty: {
            message: 'The Name is required and cannot be empty'
        }
    }
},
blkNo: {
    validators: {
        notEmpty: {
            message: 'The Name is required and cannot be empty'
        }
    }
}, 
roomType: {
    validators: {
        notEmpty: {
            message: 'The Name is required and cannot be empty'
        }
    }
},   
birthday: {
    validators: {
        notEmpty: {
            message: 'The date of birth is required'
        },
        date: {
            format: 'YYYY/MM/DD',
            message: 'The date of birth is not valid'
        },
        callback: {
            message: 'Birthday is not valid',
            callback: function(value, validator) {                        
                var selected = new Date(value).setHours(0,0,0,0) ; 
                var today = new Date().setHours(0,0,0,0) ;                            
                return selected < today;
            }
        }
    }
}
}
});
});
</script>
</script>
@stop