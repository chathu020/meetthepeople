@extends('layouts.blank')
@section('styles')
@parent
<link href="{{ asset("css/custom.css") }}" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css"/>

@stop
@section('main_container')

<div class="right_col" role="main" style="min-height: 4140px;" >

  <div class="page-title">
    <div class="title_left">
      <h3>Clients <small>Management</small></h3>
      <hr> 
  </div>
</div>

<div class="clearfix"></div>
<div class="container">
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
        <div class="well">

         {!! Form::open(['class' => 'form-horizontal','route' => 'clients.store', 'id'=> 'clientForm']) !!}

         <fieldset>
           <legend>Personal Particulars</legend>
           <!-- NRIC -->   
           <div class="form-group row">
            {!! Form::label('nric', 'NRIC', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-4">
                @if(isset($client) )
                {!! Form::text('nric',  null, ['class' => 'form-control' ,'readonly' => 'true']) !!}
                @else
                {!! Form::text('nric',  null, ['class' => 'form-control']) !!}
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
            {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-4">
                {!! Form::text('name', $value = null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            </div>
            {!! Form::label('dateOfBirth', 'Birthday', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-4">
                {!! Form::date('dateOfBirth', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'birthday']) !!}
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

        <!-- blkNo -->   
        <div class="form-group row">
            {!! Form::label('blkNo', 'Block No', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-4">
                {!! Form::text('blkNo', $value = null, ['class' => 'form-control', 'placeholder' => 'Block No']) !!}
            </div>
            {!! Form::label('accomodationType', 'Accommodation', ['class' => 'col-md-2 control-label']) !!}
            <div class=" col-md-4">    
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


        <!-- Address -->
        <div class="form-group row">
            {!! Form::label('address', 'Street Name', ['class' => 'col-md-2 control-label']) !!}
            <div class="col-md-4">
                {!! Form::textarea('address', $value = null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
            <div class="col-md-6">
              {!! Form::label('roomType', 'Type', ['class' => 'col-md-4 control-label']) !!}
              <div class=" col-md-8">    
                <select id="roomType" name="roomType" value="roomType" class="form-control">

                </select>
            </div>
            <div class=" col-md-12"> 
             <div class=" row"> 
               {!! Form::label('status', 'Status', ['class' => 'col-md-4 control-label']) !!}
               <div class="col-md-8">
                <div class="form-check form-check-inline ">                    
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
</div>
</div>
<!-- Unit No -->   
<div class="form-group row">
    {!! Form::label('unitNo', 'Unit No', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('unitNo', $value = null, ['class' => 'form-control', 'placeholder' => 'Unit No']) !!}
    </div>
</div>

<!-- Postal Code -->   
<div class="form-group row">
    {!! Form::label('postalCode', 'Postal Code', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('postalCode', $value = null, ['class' => 'form-control', 'placeholder' => 'Postal Code']) !!}
    </div>
    <div id="postalvalid-box"  class="square blue"></div> 
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
           <div class="prefer">   Prefferred?</div>
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
        {!! Form::checkbox('preferred[]', 'mobile', false, ['id' => 'mobile','class' => 'form-check-input']) !!}   
    </div>
</div>

<!-- officeTel -->   
<div class="form-group row">
    {!! Form::label('officeTel', 'Office Tel No', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">
        {!! Form::number('officeTel', $value = null,['id' => 'officeTel','class' => 'form-control  no-spinners', 'placeholder' => 'Office Tel No']) !!}
    </div>
    <div class="col-md-1"> 
        {!! Form::checkbox('preferred[]',  'office', false, ['id' => 'office','class' => 'form-check-input']) !!}   
    </div>
</div>

<!-- homeTel -->   
<div class="form-group row">
    {!! Form::label('homeTel', 'Home Tel No', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">
        {!! Form::number('homeTel', $value = null,['id' => 'homeTel','class' => 'form-control  no-spinners', 'placeholder' => 'Home Tel No']) !!}
    </div>
    <div class="col-md-1"> 
        {!! Form::checkbox('preferred[]',  'home', false, ['id' => 'home','class' => 'form-check-input']) !!}   
    </div>
</div>
<!-- pagerNo -->   
<div class="form-group row">
    {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">
        {!! Form::text('email', $value = null, ['id' => 'email','class' => 'form-control  no-spinners', 'placeholder' => 'Email Address']) !!}
    </div>
    <div class="col-md-1"> 
        {!! Form::checkbox('preferred[]',  'email', false, ['id' => 'email','class' => 'form-check-input']) !!}   
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
            {!! Form::checkbox('language[]', 'eng', false, ['id' => 'eng'], ['class' => 'form-check-input']) !!}
            {!! Form::label('language', 'Eng',['class' => 'form-check-label']) !!}
        </div>

        <div class="form-check form-check-inline">                    
            {!! Form::checkbox('language[]', 'mand', false, ['id' => 'mand'], ['class' => 'form-check-input']) !!}
            {!! Form::label('language', 'Mand',['class' => 'form-check-label']) !!}
        </div>

        <div class="form-check form-check-inline">                    
            {!! Form::checkbox('language[]', 'malay', false, ['id' => 'malay'], ['class' => 'form-check-input']) !!}
            {!! Form::label('language', 'Malay',['class' => 'form-check-label']) !!}
        </div>


        <div class="form-check form-check-inline">                    
            {!! Form::checkbox('language[]', 'tamil', false, ['id' => 'tamil'], ['class' => 'form-check-input']) !!}
            {!! Form::label('language', 'Tamil',['class' => 'form-check-label']) !!}
        </div>


        <div class="form-check form-check-inline">                    
            {!! Form::checkbox('language[]', 'dialet', false, ['id' => 'dialet'], ['class' => 'form-check-input']) !!}
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
</div>
</div>
</fieldset>
<!-- Submit Button -->
<div class="form-group">
    <div class="col-md-10 col-md-offset-2">
        <a href="/clients" class="btn btn-md btn-default pull-right">Cancel</a>
        <button class="btn btn-md btn-info pull-right" type="submit" value="Submit"><i class="fa fa-save fa-fw"></i>Add</button>
        
    </div>
</div>

</fieldset>

{!! Form::close()  !!}

</div>
</div>
</div>
</div>
@stop


@section('scripts')
@parent
<script>
var accommodation = 'Hdb';
var roomType= null;
</script>
<script src="{{ asset("js/client.js") }}"></script> 
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>

<script  type="text/javascript">
  $('#clientForm').on('status.field.bv', function (e, data) {

    var element = data.element;
    $(element).next('.glyphicon').removeClass('glyphicon-ok glyphicon-remove');
      $(element).nextAll('.help-block').html('');
      $(element).parent('.form-group').removeClass('has-success has-error');
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
                   }, 
                   callback:{
                       message: 'NRIC is not valid',
                       callback: function(value, validator) { 
                        if (value.length != 9) 
                            return false;

                        value = value.toUpperCase();

                        var i, 
                        icArray = [];
                        for(i = 0; i < 9; i++) {
                            icArray[i] = value.charAt(i);
                        }

                        icArray[1] = parseInt(icArray[1], 10) * 2;
                        icArray[2] = parseInt(icArray[2], 10) * 7;
                        icArray[3] = parseInt(icArray[3], 10) * 6;
                        icArray[4] = parseInt(icArray[4], 10) * 5;
                        icArray[5] = parseInt(icArray[5], 10) * 4;
                        icArray[6] = parseInt(icArray[6], 10) * 3;
                        icArray[7] = parseInt(icArray[7], 10) * 2;

                        var weight = 0;
                        for(i = 1; i < 8; i++) {
                            weight += icArray[i];
                        }

                        var offset = (icArray[0] == "T" || icArray[0] == "G") ? 4:0;
                        var temp = (offset + weight) % 11;

                        var st = ["J","Z","I","H","G","F","E","D","C","B","A"];
                        var fg = ["X","W","U","T","R","Q","P","N","M","L","K"];

                        var theAlpha;
                        if (icArray[0] == "S" || icArray[0] == "T") { theAlpha = st[temp]; }
                        else if (icArray[0] == "F" || icArray[0] == "G") { theAlpha = fg[temp]; }

                        return (icArray[8] === theAlpha);
                    },
                    // Send { nric: 'its value', type: 'nric' } to the back-end
                    remote: {
                        message: 'This nric number is already registered',
                        url: '/checkNRIC'                                    
                    }
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
                console.log(today);   
                console.log(selected);                   
                return selected < today;
            }
        }
    }
},
 postalCode: {
                message: 'The Post is not valid',
                validators: {
                   callback:{
                       message: '',
                       callback: function(value, validator) {                         
                            $.get("/validatePostalcode/" + value,              
        function(data) {  
             console.log(data);     
        console.log(data== "false");              
         if(data== "false"){
            //show red box
            $('#postalvalid-box').show();
         }else {
             $('#postalvalid-box').hide();
         }
        });
                            return true;
                        }
                    }
                }
            },
}
});
});
</script>
</script>
@stop
